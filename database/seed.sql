USE batik_store;

-- Admin: username=admin, password=admin
INSERT INTO
    admin (username, password)
VALUES (
        'admin',
        '$2y$10$AIy0X1Ep6alaHDTofiChGeqq7k/d1Kc8vKQf1JZo0mKrzkkj6M626'
    );

-- Sample products
INSERT INTO
    products (
        product_code,
        name,
        price,
        size,
        weight,
        description,
        image
    )
VALUES (
        'P0001',
        'Mega Mendung',
        '20000,30000',
        'm,l',
        500,
        'Hand-drawn Mega Mendung motif batik.',
        '5f8271f209bee.jpg'
    ),
    (
        'P0002',
        'Sarimbit Batik',
        '15000,18000,20000,30000,50000',
        's,m,l,xl,xxl',
        100,
        'Sarimbit batik with beautiful motifs.',
        '5f83a163d58a7.jpg'
    ),
    (
        'P0003',
        'Yellow Sarimbit Batik',
        '20000,30000,50000',
        's,l,m',
        100,
        'Yellow sarimbit batik with beautiful motifs.',
        '5f83a1b5616e3.jpg'
    );

-- Sample inventory
INSERT INTO
    inventory (
        material_code,
        name,
        qty,
        unit,
        price,
        date
    )
VALUES (
        'M0001',
        'Fabric',
        '96',
        'Kodi',
        8000,
        '2020-10-05'
    ),
    (
        'M0002',
        'Dye',
        '500',
        'ml',
        200,
        '2020-10-04'
    );

-- Sample BOM
INSERT INTO
    product_bom (
        bom_code,
        material_code,
        product_code,
        product_name,
        requirement
    )
VALUES (
        'B0001',
        'M0001',
        'P0001',
        'Mega Mendung',
        '1'
    ),
    (
        'B0002',
        'M0002',
        'P0001',
        'Mega Mendung',
        '20'
    ),
    (
        'B0003',
        'M0001',
        'P0002',
        'Sarimbit Batik',
        '2'
    );