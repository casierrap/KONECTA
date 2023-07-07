/* Consulta para conocer cuál es el producto que más stock tiene. */
SELECT * FROM konecta.products ORDER BY stock DESC LIMIT 1;

/* Consulta para conocer cuál es el producto más vendido. */
SELECT konecta.products.nombreProducto, SUM(quantity) AS total 
FROM konecta.sales 
INNER JOIN konecta.products ON konecta.products.id = konecta.sales.productId
GROUP BY konecta.sales.productId
ORDER BY SUM(quantity) DESC
LIMIT 1;
