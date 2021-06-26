# Рубежный контроль

## Теория

### Отличия RIGHT от LEFT JOIN
LEFT JOIN: возвращает все строки из левой таблицы, даже если в правой таблице нет совпадений.
Иными словами, если мы присоединяем к «левой» таблице «правую», то выберутся все записи в соответствии с условиями WHERE для левой таблицы. Если в «правой» таблице не было соответствий по ключам, они будут возвращены как NULL. Таким образом, здесь главной выступает «левая» таблица, и относительно нее идет выдача. В условии ON «левая» таблица прописывается первой по порядку, а «правая» – второй.

![show_left](/img/left-join.png)

RIGHT JOIN: возвращает все строки из правой таблицы, даже если в левой таблице нет совпадений.
То есть примерно также, как и в LEFT JOIN, только NULL вернется для полей «левой» таблицы. Грубо говоря, эта выборка ставит во главу угла правую «таблицу», относительно нее идет выдача.

![show_right](/img/right-join.png)

### Отличия CROSS от INNER JOIN
CROSS JOIN: возвращает декартово произведение строк, то есть объединяет все строки TableA со всеми строками в TableB, это значит, что если в TableA 4 записи и в TableB 4 записи, то получится 4х4=16 записей.

![show_cross](/img/cross-join.png)

INNER JOIN: возвращает набор записей, который удовлетворяет как первой таблице, так и второй.

![show_inner](/img/inner-join.png)

## Примеры
У нас есть две таблицы:

TableA

![TableA](/img/TableA.png)

TableB

![TableB](/img/TableB.png)

### Демонстрация работы RIGHT JOIN
`SELECT * FROM TableA RIGHT JOIN TableB ON TableA.id = TableB.id;`

##### Результат:

![RIGHT_JOIN](/img/RIGHT.png)

### Демонстрация работы LEFT JOIN
`SELECT * FROM TableA LEFT JOIN TableB ON TableA.id = TableB.id;`

##### Результат:

![LEFT_JOIN](/img/LEFT.png)

### Демонстрация работы CROSS JOIN
`SELECT * FROM TableA CROSS JOIN TableB;`

##### Результат:

Пример с `ON`

![CROSS_JOIN_ON](/img/CROSS_ON.png)

Пример с `WHERE`

![CROSS_JOIN_WHERE](/img/CROSS_WHERE.png)

Пример без условий

![CROSS_JOIN](/img/CROSS.png)

### Демонстрация работы INNER JOIN
`SELECT * FROM TableA INNER JOIN TableB;`

##### Результат:

Пример с `ON`

![INNER_JOIN_ON](/img/INNER_ON.png)

Пример с `WHERE`

![INNER_JOIN_WHERE](/img/INNER_WHERE.png)

Пример без условий

![INNER_JOIN](/img/INNER.png)

Как можно заметить из примеров CROSS и INNER JOIN могут заменить друг друга, то есть в случае MySQL они синтаксически эквивалентны.

## Использованные источники
- [Краткое руководство по Маркдауну](https://paulradzkov.com/2014/markdown_cheatsheet);
- [CROSS JOIN против INNER JOIN в SQL](https://qastack.ru/programming/17759687/cross-join-vs-inner-join-in-sql);
- [В чем разница между JOIN](https://coderoad.ru/5706437/%D0%92-%D1%87%D0%B5%D0%BC-%D1%80%D0%B0%D0%B7%D0%BD%D0%B8%D1%86%D0%B0-%D0%BC%D0%B5%D0%B6%D0%B4%D1%83-%D0%B2%D0%BD%D1%83%D1%82%D1%80%D0%B5%D0%BD%D0%BD%D0%B8%D0%BC-JOIN-%D0%BB%D0%B5%D0%B2%D1%8B%D0%BC-JOIN-%D0%BF%D1%80%D0%B0%D0%B2%D1%8B%D0%BC-JOIN-%D0%B8-%D0%BF%D0%BE%D0%BB%D0%BD%D1%8B%D0%BC-JOIN);
- [A Visual Explanation of SQL Joins](https://blog.codinghorror.com/a-visual-explanation-of-sql-joins).
