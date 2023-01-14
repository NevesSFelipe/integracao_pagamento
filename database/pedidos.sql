CREATE TABLE IF NOT EXISTS "pedidos" (
    "id" SERIAL primary key,
    "valor_total" NUMERIC(12, 2),
    "valor_frete" NUMERIC(12, 2),
    "data" TIMESTAMP,
    "id_cliente" INT,
    "id_loja" INT,
    "id_situacao" INT
);
INSERT INTO "pedidos" VALUES
    (98302,250.74,33.4,'2021-08-20 00:00:00',8796,90,1),
    (98303,583.92,57.85,'2021-08-23 00:00:00',5789,92,1),
    (98304,97.25,17.5,'2021-08-23 00:00:00',6748,90,2),
    (98305,66.89,22.55,'2021-08-25 00:00:00',6872,115,2),
    (98306,115.9,19.5,'2021-08-25 00:00:00',6716,98,1),
    (98307,153.72,25.5,'2021-08-25 00:00:00',4802,97,1),
    (98308,87.9,13.5,'2021-08-26 00:00:00',9484,94,1),
    (98309,223.9,28.75,'2021-08-27 00:00:00',1830,90,2),
    (98310,58.9,19.85,'2021-08-27 00:00:00',2280,92,1);
