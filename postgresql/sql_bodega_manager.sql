-- CREACIÓN DE TABLAS --

create table producto (
	id serial primary key,
	nombre varchar(100) not null,
	sku varchar(50) not null,
	stock integer default 0 check (stock >= 0)
);

create table movimiento (
	id serial primary key,
	id_producto serial references producto(id),
	tipo varchar(10) check (tipo in ('Entrada', 'Salida')),
	cantidad integer not null check (cantidad > 0),
	fecha timestamp default current_timestamp
);

-- LÓGICA --

-- Función y trigger para validar y actualizar stock --
create or replace function gestionar_movimiento()
returns trigger as $$
begin
	if (new.tipo = 'Entrada') then
		update producto
		set stock = stock + new.cantidad
		where id = new.id_producto;

	elseif (new.tipo = 'Salida') then
		if ((select stock from producto where id = new.id_producto) < new.cantidad) then
			raise exception 'Stock insuficiente. Intentas sacar % pero hay % unidades en stock', new.cantidad, (select stock from producto where id = new.id_producto);
		else 
			update producto
			set stock = stock - new.cantidad
			where id = new.id_producto;
		end if;
	end if;
return new;
end
$$ language 'plpgsql';

create or replace trigger trg_actualizar_stock
before insert on movimiento
for each row
execute procedure gestionar_movimiento();
