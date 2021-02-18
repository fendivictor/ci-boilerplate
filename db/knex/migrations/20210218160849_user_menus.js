exports.up = function(knex) {
	return knex.schema.createTable("user_menus", function(table) {
		table.increments("id").primary();
		table
			.integer("id_menu")
			.notNullable()
			.defaultTo(0);
		table
			.string("username")
			.notNullable()
			.defaultTo("");
		table
			.string("user_insert")
			.notNullable()
			.defaultTo("");
		table.timestamp("insert_at", { useTz: true }).defaultTo(knex.fn.now());
	});
};

exports.down = function(knex) {
	return knex.schema.dropTable("user_menus");
};
