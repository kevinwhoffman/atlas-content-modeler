import { sanitizeFields, getTitleFieldId, getOpenField } from "./queries";

describe("sanitizeFields", () => {
	it("moves children to subfields", () => {
		const fields = {
			123: { id: 123 },
			456: { id: 456 },
			789: { id: 789 },
		};

		const expected = {
			123: { id: 123 },
			456: { id: 456 },
			789: { id: 789 },
		};

		expect(sanitizeFields(fields)).toStrictEqual(expected);
	});

	it("passes empty objects through unchanged", () => {
		expect(sanitizeFields({})).toStrictEqual({});
	});
});

describe("getTitleFieldId", () => {
	it("gets the ID of the field set as the entry title", () => {
		const fields = {
			123: { id: 123 },
			456: { id: 456 },
			789: { id: 789, isTitle: true },
		};

		const expected = 789;

		expect(getTitleFieldId(fields)).toEqual(expected);
	});
	it("gives an empty string if no field is set as the entry title", () => {
		const fields = {
			123: { id: 123 },
			456: { id: 456 },
			789: { id: 789 },
		};

		const expected = "";

		expect(getTitleFieldId(fields)).toEqual(expected);
	});
});

describe("getOpenField", () => {
	it("returns the open field if there is one", () => {
		const fields = {
			123: { id: 123, open: true },
			456: { id: 456 },
			789: { id: 789 },
		};

		const expected = { id: 123, open: true };

		expect(getOpenField(fields)).toEqual(expected);
	});
	it("returns an empty object if no field is open", () => {
		const fields = {
			123: { id: 123 },
			456: { id: 456 },
			789: { id: 789 },
		};

		const expected = {};

		expect(getOpenField(fields)).toEqual(expected);
	});
});
