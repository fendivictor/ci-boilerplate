exports.up = function(knex) {
	return knex.schema.createTable("menus", function(table) {
		table.increments("id").primary();
		table
			.string("label")
			.notNullable()
			.defaultTo("");
		table
			.string("icon")
			.notNullable()
			.defaultTo("");
		table
			.string("url")
			.notNullable()
			.defaultTo("");
		table
			.string("fungsi")
			.notNullable()
			.defaultTo("");
		table
			.string("method")
			.notNullable()
			.defaultTo("");
		table
			.integer("parents")
			.notNullable()
			.defaultTo(0);
		table
			.integer("urutan")
			.notNullable()
			.defaultTo(0);
		table
			.integer("status")
			.notNullable()
			.defaultTo(1);
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
	});
};

exports.down = function(knex) {
	return knex.schema.dropTable("menus");
};
