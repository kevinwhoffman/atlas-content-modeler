import React, { useEffect, useContext, useState } from "react";
import { useForm } from "react-hook-form";
import { Link, useHistory } from "react-router-dom";
import { ModelsContext } from "../ModelsContext";
import { insertSidebarMenuItem } from "../utils";
import { useInputGenerator } from "../hooks";
import { toPostTypeSlug } from "../formats";
import { showSuccess } from "../toasts";
import Icon from "../../../../components/icons";
import IconPicker from "./IconPicker";
import { sprintf, __ } from "@wordpress/i18n";

const { apiFetch } = wp;

export default function CreateContentModel() {
	const {
		register,
		handleSubmit,
		errors,
		setValue,
		setError,
		formState: { isSubmitting },
	} = useForm({
		defaultValues: {
			api_visibility: "private",
		},
	});

	const history = useHistory();
	const [singularCount, setSingularCount] = useState(0);
	const [pluralCount, setPluralCount] = useState(0);
	const [icon, setIcon] = useState(0);
	const [descriptionCount, setDescriptionCount] = useState(0);
	const { dispatch } = useContext(ModelsContext);
	const {
		setInputGeneratorSourceValue,
		onChangeGeneratedValue,
	} = useInputGenerator({
		setGeneratedValue: (value) => setValue("slug", value),
		format: toPostTypeSlug,
	});

	function apiCreateModel(data) {
		return apiFetch({
			path: "/wpe/atlas/content-model",
			method: "POST",
			_wpnonce: wpApiSettings.nonce,
			data,
		})
			.then((res) => {
				if (res.success) {
					dispatch({ type: "addModel", data: res.model });
					history.push(
						atlasContentModeler.appPath +
							"&view=edit-model&id=" +
							res.model.slug
					);

					// Insert the sidebar menu item below the Comments item, to avoid doing a full page refresh.
					insertSidebarMenuItem(res.model);

					window.scrollTo(0, 0);
					showSuccess(
						sprintf(
							__(
								'The "%s" model was created. Now add your first field.',
								"atlas-content-modeler"
							),
							res.model.plural
						)
					);
				}
			})
			.catch((err) => {
				if (err.code === "atlas_content_modeler_already_exists") {
					setError("slug", {
						type: "idExists",
						message: err.message,
					});
				}
			});
	}

	return (
		<div className="app-card">
			<section className="heading flex-wrap d-flex flex-column d-sm-flex flex-sm-row">
				<h2>New Content Model</h2>
				<button
					className="tertiary"
					onClick={() => history.push(atlasContentModeler.appPath)}
				>
					{__("View All Models", "atlas-content-modeler")}
				</button>
			</section>
			<section className="card-content">
				<form onSubmit={handleSubmit(apiCreateModel)}>
					<div
						className={
							errors.singular ? "field has-error" : "field"
						}
					>
						<label htmlFor="singular">Singular Name</label>
						<br />
						<p className="help">
							{__(
								'Singular display name for your content model, e.g. "Rabbit"',
								"atlas-content-modeler"
							)}
							.
						</p>
						<input
							id="singular"
							name="singular"
							placeholder="Rabbit"
							className="w-100"
							ref={register({ required: true, maxLength: 50 })}
							onChange={(e) => {
								setInputGeneratorSourceValue(e.target.value);
								setSingularCount(e.target.value.length);
							}}
						/>
						<p className="field-messages">
							{errors.singular &&
								errors.singular.type === "required" && (
									<span className="error">
										<Icon type="error" />
										<span role="alert">
											{__(
												"This field is required",
												"atlas-content-modeler"
											)}
										</span>
									</span>
								)}
							{errors.singular &&
								errors.singular.type === "maxLength" && (
									<span className="error">
										<Icon type="error" />
										<span role="alert">
											{__(
												"Exceeds max length.",
												"atlas-content-modeler"
											)}
										</span>
									</span>
								)}
							<span>&nbsp;</span>
							<span className="count">{singularCount}/50</span>
						</p>
					</div>

					<div
						className={errors.plural ? "field has-error" : "field"}
					>
						<label htmlFor="plural">Plural Name</label>
						<br />
						<p className="help">
							{__(
								'Plural display name for your content model, e.g. "Rabbits".',
								"atlas-content-modeler"
							)}
						</p>
						<input
							id="plural"
							name="plural"
							placeholder="Rabbits"
							className="w-100"
							ref={register({ required: true, maxLength: 50 })}
							onChange={(event) => {
								setPluralCount(event.target.value.length);
							}}
						/>
						<p className="field-messages">
							{errors.plural &&
								errors.plural.type === "required" && (
									<span className="error">
										<Icon type="error" />
										<span role="alert">
											{__(
												"This field is required",
												"atlas-content-modeler"
											)}
										</span>
									</span>
								)}
							{errors.plural &&
								errors.plural.type === "maxLength" && (
									<span className="error">
										<Icon type="error" />
										<span role="alert">
											{__(
												"Exceeds max length.",
												"atlas-content-modeler"
											)}
										</span>
									</span>
								)}
							<span>&nbsp;</span>
							<span className="count">{pluralCount}/50</span>
						</p>
					</div>

					<div className={errors.slug ? "field has-error" : "field"}>
						<label htmlFor="slug">
							{__("Model ID", "atlas-content-modeler")}
						</label>
						<br />
						<p className="help">
							{__(
								"Auto-generated and used internally for WordPress to identify the model.",
								"atlas-content-modeler"
							)}
						</p>
						<input
							id="slug"
							name="slug"
							className="w-100"
							ref={register({ required: true, maxLength: 20 })}
							onChange={(e) =>
								onChangeGeneratedValue(e.target.value)
							}
						/>
						<p className="field-messages">
							{errors.slug && errors.slug.type === "required" && (
								<span className="error">
									<Icon type="error" />
									<span role="alert">
										{__(
											"This field is required",
											"atlas-content-modeler"
										)}
									</span>
								</span>
							)}
							{errors.slug && errors.slug.type === "maxLength" && (
								<span className="error">
									<Icon type="error" />
									<span role="alert">
										{__(
											"Exceeds max length of 20.",
											"atlas-content-modeler"
										)}
									</span>
								</span>
							)}
							{errors.slug && errors.slug.type === "idExists" && (
								<span className="error">
									<Icon type="error" />
									<span role="alert">
										{errors.slug.message}
									</span>
								</span>
							)}
							<span>&nbsp;</span>
						</p>
					</div>

					<div
						className={
							errors.api_visibility ? "field has-error" : "field"
						}
					>
						<label htmlFor="api_visibility">API Visibility</label>
						<br />
						<p className="help">
							Whether or not this model requires authentication to
							be accessed via REST and GraphQL APIs.
						</p>

						<input
							id="api_visibility_public"
							name="api_visibility"
							type="radio"
							value="public"
							ref={register({ required: true })}
						/>
						<label htmlFor="api_visibility_public">Public</label>
						<p className="help">
							No authentication is needed for REST and GraphQL.
						</p>

						<input
							id="api_visibility_private"
							name="api_visibility"
							type="radio"
							value="private"
							ref={register({ required: true })}
						/>
						<label htmlFor="api_visibility_private">Private</label>
						<p className="help">
							REST and GraphQL requests require authentication.
						</p>

						<p className="field-messages">
							{errors.api_visibility &&
								errors.api_visibility.type === "required" && (
									<span className="error">
										<Icon type="error" />
										<span role="alert">
											This field is required
										</span>
									</span>
								)}
							<span>&nbsp;</span>
						</p>
					</div>

					<div className="field">
						<label htmlFor="model_icon">
							{__("Model Icon", "atlas-content-modeler")}
						</label>
						<br />
						<p className="help">
							{__(
								"Choose an icon to represent your model.",
								"atlas-content-modeler"
							)}
						</p>

						<IconPicker
							setValue={setValue}
							buttonClasses="primary first"
							register={register}
						/>
					</div>

					<div
						className={
							errors.description
								? "field field-description has-error"
								: "field field-description"
						}
					>
						<label htmlFor="description">Description</label>
						<br />
						<p className="help">
							{__(
								"A hint for content editors and API users.",
								"atlas-content-modeler"
							)}
						</p>
						<textarea
							id="description"
							name="description"
							className="w-100"
							ref={register({ maxLength: 250 })}
							onChange={(e) =>
								setDescriptionCount(e.target.value.length)
							}
						/>
						<p className="field-messages">
							{errors.description &&
								errors.description.type === "maxLength" && (
									<span className="error">
										<Icon type="error" />
										<span role="alert">
											{__(
												"Exceeds max length.",
												"atlas-content-modeler"
											)}
										</span>
									</span>
								)}
							<span>&nbsp;</span>
							<span className="count">
								{descriptionCount}/250
							</span>
						</p>
					</div>

					<button
						type="submit"
						disabled={isSubmitting}
						className="primary first"
					>
						Create
					</button>
					<button
						className="tertiary"
						disabled={isSubmitting}
						onClick={() =>
							history.push(atlasContentModeler.appPath)
						}
					>
						Cancel
					</button>
				</form>
			</section>
		</div>
	);
}
