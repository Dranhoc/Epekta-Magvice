export default {
	values: Object.freeze({
		WAITING: Symbol(1),
		PAID: Symbol(2),
		CANCELED: Symbol(3),
	}),
	labels: {
		1: "En attente",
		2: "Payé",
		3: "Annulé",
	},
};
