module.exports = {
	development: {
		client: "mysql",
		connection: "mysql://root:1234@localhost:3306/testdb",
		migrations: {
			directory: __dirname + "/knex/migrations"
		},
		seeds: {
			directory: __dirname + "/knex/seeds"
		}
	},

	production: {
		client: "mysql",
		connection: "mysql://root:1234@localhost:3306/testdb"
	}
};
