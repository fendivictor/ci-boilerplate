exports.seed = function(knex) {
	// Deletes ALL existing entries
	return knex("users")
		.del()
		.then(function() {
			// Inserts seed entries
			return knex("users").insert([
				{
					id: 1,
					username: "admin",
					password: "7cfa28cde915ea86f0906b343435ce28",
					profile_name: "Super Admin",
					image: "",
					phone: "",
					session: "",
					language: ""
				}
			]);
		});
};
