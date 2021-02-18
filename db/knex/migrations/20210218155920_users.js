exports.up = function(knex) {
	return knex.schema.createTable("users", function(table) {
		table.increments("id").primary();
		table
			.string("username")
			.notNullable()
			.defaultTo("");
		table
			.string("password")
			.notNullable()
			.defaultTo("");
		table
			.string("profile_name")
			.notNullable()
			.defaultTo("");
		table
			.string("image")
			.notNullable()
			.defaultTo("");
		table
			.string("phone")
			.notNullable()
			.defaultTo("");
		table
			.string("session")
			.notNullable()
			.defaultTo("");
		table.timestamp("last_login", { useTz: true });
		table
			.string("language")
			.notNullable()
			.defaultTo("");
		table
			.string("user_insert")
			.notNullable()
			.defaultTo("");
		table.timestamp("insert_at", { useTz: true }).defaultTo(knex.fn.now());
		table
			.string("user_update")
			.notNullable()
			.defaultTo("");
		table.timestamp("update_at", { useTz: true });
		table
			.integer("status")
			.notNullable()
			.defaultTo(1);
	});
};

exports.down = function(knex) {
	return knex.schema.dropTable("users");
};
