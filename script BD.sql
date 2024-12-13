use sistemaweb;

-- Crear tabla Usuarios
CREATE TABLE usuarios (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  contraseña VARCHAR(255) NOT NULL,
  tipo_usuario ENUM('cliente', 'administrador') NOT NULL
);

-- Crear tabla Productos
CREATE TABLE productos (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  precio_venta DECIMAL(10, 2) NOT NULL
);

-- Crear tabla Ingredientes
CREATE TABLE ingredientes (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  cantidad_disponible DECIMAL(10, 2) NOT NULL,
  unidad_medida VARCHAR(50) NOT NULL,
  nivel_minimo DECIMAL(10, 2) NOT NULL
);

-- Crear tabla Recetas
CREATE TABLE recetas (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  producto_id BIGINT NOT NULL,
  ingrediente_id BIGINT NOT NULL,
  cantidad DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (producto_id) REFERENCES productos(id),
  FOREIGN KEY (ingrediente_id) REFERENCES ingredientes(id)
);

-- Crear tabla Pedidos
CREATE TABLE pedidos (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  usuario_id BIGINT NOT NULL,
  fecha_entrega DATE NOT NULL,
  direccion_entrega VARCHAR(255) NOT NULL,
  total DECIMAL(10, 2) NOT NULL,
  instrucciones_especiales TEXT,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Crear tabla Detalle de Pedidos
CREATE TABLE detalle_pedidos (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  pedido_id BIGINT,
  producto_id BIGINT,
  cantidad DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
  FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Crear tabla Facturas
CREATE TABLE facturas (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  pedido_id BIGINT,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  total DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);

-- Crear tabla Movimientos de Inventario
CREATE TABLE movimientos_inventario (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  ingrediente_id BIGINT,
  cantidad DECIMAL(10, 2) NOT NULL,
  tipo_movimiento VARCHAR(50) NOT NULL CHECK (tipo_movimiento IN ('entrada', 'salida')),
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (ingrediente_id) REFERENCES ingredientes(id)
);

INSERT INTO usuarios (nombre, email, contraseña, tipo_usuario)
VALUES 
('Juan Pérez', 'juan.perez@example.com', 'contraseña123', 'cliente'),
('Ana Gómez', 'ana.gomez@example.com', 'password456', 'administrador');

select * from usuarios;

UPDATE usuarios SET contraseña = '$2y$10$zbZAhc83PHS8d7WxvGT1HO8YTZa5uVB3xPgGVW2N7EevQ5zwZptcK' WHERE email = 'juan.perez@example.com';
UPDATE usuarios SET contraseña = '$2y$10$/Fz2cGlZfNs0/J.YJY468.TWOO5HKJ8ff2zeiT4ymZk7aiWx2a0tW' WHERE email = 'ana.gomez@example.com';

