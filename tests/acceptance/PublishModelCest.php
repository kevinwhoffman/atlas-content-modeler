<?php
use Codeception\Util\Locator;
class PublishModelCest
{
	public function _before(\AcceptanceTester $i)
	{
		$i->maximizeWindow();

		// First we create a model with fields.
		$i->loginAsAdmin();
		$i->haveContentModel('goose', 'geese', 'geese go honk');
		$i->wait(1);
	}

	public function i_see_submission_errors_in_number_fields_when_input_is_missing_for_the_number_type(\AcceptanceTester $i)
	{
		$i->click('Number', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Integer');
		$i->click('.open-field button.primary');
		$i->wait(1);

		$i->click(Locator::lastElement('.add-item'));
		$i->click('Number', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Decimal');
		$i->click('input#decimal');
		$i->checkOption('required');
		$i->click('.open-field button.primary');
		$i->wait(1);

		// Next we create an entry for our new model.
		$i->amOnPage('/wp-admin/edit.php?post_type=goose');
		$i->click('Add New', '.wrap');
		$i->wait(1);

		$i->fillField(['name' => 'atlas-content-modeler[goose][integer]'], '');
		$i->fillField(['name' => 'atlas-content-modeler[goose][decimal]'], '');
		$i->scrollTo('#submitdiv');

		$i->click('Publish', '#publishing-action');
		$i->wait(2);

		$i->see('This field is required');
		$i->wait(1);

		$i->seeInField('atlas-content-modeler[goose][integer]', '');
		$i->seeInField('atlas-content-modeler[goose][decimal]', '');
	}

	public function i_see_no_submission_errors_in_number_fields_when_input_is_missing_for_the_number_type(\AcceptanceTester $i)
	{
		$i->click('Number', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Integer');
		$i->click('.open-field button.primary');
		$i->wait(1);

		$i->click(Locator::lastElement('.add-item'));
		$i->click('Number', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Decimal');
		$i->click('input#decimal');
		$i->click('.open-field button.primary');
		$i->wait(1);

		// Next we create an entry for our new model.
		$i->amOnPage('/wp-admin/edit.php?post_type=goose');
		$i->click('Add New', '.wrap');
		$i->wait(1);

		$i->fillField(['name' => 'atlas-content-modeler[goose][integer]'], '');
		$i->fillField(['name' => 'atlas-content-modeler[goose][decimal]'], '');
		$i->scrollTo('#submitdiv');

		$i->click('Publish', '#publishing-action');
		$i->wait(2);

		$i->cantSee('This field is required');
		$i->wait(1);

		$i->seeInField('atlas-content-modeler[goose][integer]', '');
		$i->seeInField('atlas-content-modeler[goose][decimal]', '');
	}

	public function i_see_submission_errors_in_number_fields_when_input_is_less_than_min_for_the_number_type(\AcceptanceTester $i)
	{
		$i->click('Number', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Integer');
		$i->click('.open-field button.settings');
		$i->fillField(['name' => 'minValue'], '0');
		$i->fillField(['name' => 'maxValue'], '10');
		$i->fillField(['name' => 'step'], '1');
		$i->click('.ReactModal__Content button.primary');
		$i->wait(1);

		$i->click('.open-field button.primary');
		$i->wait(1);

		$i->click(Locator::lastElement('.add-item'));
		$i->click('Number', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Decimal');
		$i->click('input#decimal');
		$i->click('.open-field button.settings');
		$i->fillField(['name' => 'minValue'], '0');
		$i->fillField(['name' => 'maxValue'], '2.5');
		$i->fillField(['name' => 'step'], '1.1');
		$i->click('.ReactModal__Content button.primary');

		$i->click('.open-field button.primary');
		$i->wait(1);

		// Next we create an entry for our new model.
		$i->amOnPage('/wp-admin/edit.php?post_type=goose');
		$i->click('Add New', '.wrap');
		$i->wait(1);

		$i->fillField(['name' => 'atlas-content-modeler[goose][integer]'], '-1');
		$i->fillField(['name' => 'atlas-content-modeler[goose][decimal]'], '-1');
		$i->scrollTo('#submitdiv');

		$i->click('Publish', '#publishing-action');
		$i->wait(2);

		$i->see('Minimum value is', '#field-integer');
		$i->see('Minimum value is', '#field-decimal');
		$i->wait(1);

		$i->seeInField('atlas-content-modeler[goose][integer]', '-1');
		$i->seeInField('atlas-content-modeler[goose][decimal]', '-1');
	}

	public function i_see_submission_errors_in_number_fields_when_input_is_more_than_max_for_the_number_type(\AcceptanceTester $i)
	{
		$i->click('Number', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Integer');
		$i->click('.open-field button.settings');
		$i->fillField(['name' => 'minValue'], '0');
		$i->fillField(['name' => 'maxValue'], '10');
		$i->fillField(['name' => 'step'], '1');
		$i->click('.ReactModal__Content button.primary');
		$i->wait(1);

		$i->click('.open-field button.primary');
		$i->wait(1);

		$i->click(Locator::lastElement('.add-item'));
		$i->click('Number', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Decimal');
		$i->click('input#decimal');
		$i->click('.open-field button.settings');
		$i->fillField(['name' => 'minValue'], '0');
		$i->fillField(['name' => 'maxValue'], '2.5');
		$i->fillField(['name' => 'step'], '1.1');
		$i->click('.ReactModal__Content button.primary');

		$i->click('.open-field button.primary');
		$i->wait(1);

		// Next we create an entry for our new model.
		$i->amOnPage('/wp-admin/edit.php?post_type=goose');
		$i->click('Add New', '.wrap');
		$i->wait(1);

		$i->fillField(['name' => 'atlas-content-modeler[goose][integer]'], '20');
		$i->fillField(['name' => 'atlas-content-modeler[goose][decimal]'], '20');
		$i->scrollTo('#submitdiv');

		$i->click('Publish', '#publishing-action');
		$i->wait(2);

		$i->see('Maximum value is', '#field-integer');
		$i->see('Maximum value is', '#field-decimal');
		$i->wait(1);

		$i->seeInField('atlas-content-modeler[goose][integer]', '20');
		$i->seeInField('atlas-content-modeler[goose][decimal]', '20');
	}

	public function i_can_publish_a_model_entry(AcceptanceTester $i)
	{
		$i->click('Text', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Color');
		$i->click('.open-field button.primary');
		$i->wait(1);

		$i->click(Locator::lastElement('.add-item'));
		$i->click('Rich Text', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Description');
		$i->click('.open-field button.primary');
		$i->wait(1);

		$i->click(Locator::lastElement('.add-item'));
		$i->click('Rich Text', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Another rich text field');
		$i->click('.open-field button.primary');
		$i->wait(1);

		$i->click(Locator::lastElement('.add-item'));
		$i->click('Number', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Age');
		$i->click('.open-field button.primary');
		$i->wait(1);

		$i->click(Locator::lastElement('.add-item'));
		$i->click('Date', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Date of Birth');
		$i->click('.open-field button.primary');
		$i->wait(1);

		$i->click(Locator::lastElement('.add-item'));
		$i->click('Boolean', '.field-buttons');
		$i->fillField(['name' => 'name'], 'Flies south for winter?');
		$i->click('.open-field button.primary');
		$i->wait(1);

		// Next we create an entry for our new model.
		$i->amOnPage('/wp-admin/edit.php?post_type=goose');
		$i->click('Add New', '.wrap');
		$i->wait(1);

		$i->fillField(['name' => 'atlas-content-modeler[goose][color]'], 'Gray');
		$i->fillField(['name' => 'atlas-content-modeler[goose][age]'], '100');
		$i->fillField(['name' => 'atlas-content-modeler[goose][dateOfBirth]'], '01/01/2021');
		$i->checkOption('atlas-content-modeler[goose][fliesSouthForWinter]');

		// Rich text fields rendered as TinyMCE live in an iframe.
		$i->switchToIFrame('#field-description iframe');
		$i->fillField('#tinymce', 'I am a goose');
		$i->switchToIFrame(); // switch back to main window

		// Fill the second TinyMCE field.
		$i->switchToIFrame('#field-anotherRichTextField iframe');
		$i->fillField('#tinymce', 'I am another rich text field');
		$i->switchToIFrame(); // switch back to main window
		$i->scrollTo('#submitdiv');


		$i->click('Publish', '#publishing-action');
		$i->wait(2);

		$i->see('Post published.');
		$i->wait(1);
		$i->see('Edit goose'); // Page title should change from “Add goose” when published.

		$i->seeInField('atlas-content-modeler[goose][color]', 'Gray');
		$i->seeInField('atlas-content-modeler[goose][age]', '100');
		$i->seeInField('atlas-content-modeler[goose][dateOfBirth]', '2021-01-01');
		$i->seeCheckboxIsChecked('atlas-content-modeler[goose][fliesSouthForWinter]');
		$i->switchToIFrame('#field-description iframe');
		$i->see('I am a goose'); // Sees the text in the TinyMCE iframe body.
		$i->switchToIFrame();

		// Show <textarea> elements hidden by TinyMCE so we can see them to check their values directly.
		$i->executeJS("
			var field = document.getElementsByName('atlas-content-modeler[goose][description]');
			field[0].removeAttribute('style');
			var fieldTwo = document.getElementsByName('atlas-content-modeler[goose][anotherRichTextField]');
			fieldTwo[0].removeAttribute('style');
		");

		$i->seeInField('atlas-content-modeler[goose][description]', '<p>I am a goose</p>');
		$i->seeInField('atlas-content-modeler[goose][anotherRichTextField]', '<p>I am another rich text field</p>');
	}
}
