export default {
	values: Object.freeze({
		ROOT: Symbol(1),
		ADMIN: Symbol(2),
		MODERATOR: Symbol(3),
		USER: Symbol(4),
	}),
	labels: {
		1: "Root",
		2: "Administrateur",
		3: "Modérateur",
		4: "Utilisateur",
	},
};
