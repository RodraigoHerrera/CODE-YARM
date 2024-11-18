CREATE DATABASE universidad;
USE universidad;

CREATE TABLE carrera (
    codcarrera INT PRIMARY KEY,
    descripcion VARCHAR(50) NOT NULL,
    especialidad VARCHAR(50)
);

CREATE TABLE estudiante (
    nro INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    telefono VARCHAR(15),
    telefono_familiar VARCHAR(15)
);

CREATE TABLE Asignatura (
    codigo VARCHAR(10) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    semestre INT,
    carrera INT,
    FOREIGN KEY (carrera) REFERENCES carrera(codcarrera)
);

CREATE TABLE matricula (
    estudiante INT,
    asignatura VARCHAR(10),
    fecha_matriculacion DATE,
    nota INT,
    PRIMARY KEY (estudiante, asignatura),
    FOREIGN KEY (estudiante) REFERENCES estudiante(nro),
    FOREIGN KEY (asignatura) REFERENCES asignatura(codigo)
);

INSERT INTO carrera (codcarrera, descripcion, especialidad) VALUES
(1, 'Ingeniería de Sistemas', 'IA'),
(2, 'Ingeniería Industrial', 'Procesos');

INSERT INTO estudiante (nro, nombre, fecha_nacimiento, telefono, telefono_familiar) VALUES
(1, 'Clara Alarcon', '2002-02-14', '78452145', '71244889'),
(2, 'Dario Lopez', '2000-12-25', '69144555', '22785411');

INSERT INTO asignatura (codigo, nombre, semestre, carrera) VALUES
('BD-II', 'Base de Datos II', 5, 2),
('ISO-I', 'Ingeniería de Software I', 4, 1);

INSERT INTO matricula (estudiante, asignatura, fecha_matriculacion, nota) VALUES
(2, 'ISO-I', '2024-07-25', 86),
(1, 'BD-II', '2024-08-02', 91),
(2, 'BD-II', '2024-07-31', 95);

select * from carrera;
select * from carrera;
select * from carrera;