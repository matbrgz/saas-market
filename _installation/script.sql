create table blocked_ips
(
  ip varchar(48) not null
    primary key
)
  charset = utf8;

create table failed_logins
(
  id                    int auto_increment
    primary key,
  user_email            varchar(64)     not null
  comment 'It doesnt reference email in table users, this will prevent even unregistered users as well',
  last_failed_login     int             null
  comment 'unix timestamp of last failed login',
  failed_login_attempts int default '0' not null,
  constraint failed_logins_user_email_uindex
  unique (user_email)
)
  charset = utf8;

create table ip_failed_logins
(
  ip         varchar(48) not null,
  user_email varchar(64) not null
  comment 'It doesnt reference email in table users',
  primary key (ip, user_email)
)
  charset = utf8;

create table jobs
(
  id          int                                 not null
    primary key,
  description varchar(128)                        not null,
  data_job    timestamp default CURRENT_TIMESTAMP null,
  user_id     int                                 not null
);

create table users
(
  id                      int auto_increment
    primary key,
  session_id              varchar(48)                       null,
  cookie_token            varchar(128)                      null,
  name                    varchar(48)                       not null,
  cpf                     bigint(11)                        not null,
  birthday                int(8)                            not null,
  role                    varchar(16) default 'user'        not null,
  hashed_password         varchar(128)                      not null,
  email                   varchar(64)                       not null,
  is_email_activated      tinyint(1) default '0'            not null,
  email_token             varchar(48)                       null,
  email_last_verification int                               null
  comment 'unix timestamp',
  pending_email           varchar(64)                       null
  comment 'temporary email that will be used when user updates his current one',
  pending_email_token     varchar(48)                       null,
  postal_code             int(16)                           not null,
  country_iso             varchar(2)                        not null
  comment 'two-letter only accordion with ISO 3166-1 alpha-2',
  state_abbr              varchar(2)                        not null
  comment 'state name abbreviated',
  city                    varchar(120)                      not null,
  address1                varchar(120)                      not null,
  address2                varchar(120)                      null,
  phone                   bigint(11)                        not null,
  profile_picture         varchar(48) default 'default.png' not null
  comment 'The base name for the image. Its not always unique because of default.jpg',
  constraint users_email_uindex
  unique (email)
)
  charset = utf8;

create table bills
(
  id          int          not null,
  user_id     int          not null,
  description varchar(128) null,
  data_job    timestamp    null,
  constraint bills_users_id_fk
  foreign key (user_id) references users (id)
    on update cascade
    on delete cascade
);

create index bills_users_id_fk
  on bills (user_id);

create table budgets
(
  id          int auto_increment
    primary key,
  user_id     int                                 not null,
  product_id  int                                 null,
  supplier_id int                                 null,
  description varchar(512)                        not null,
  status      varchar(64) default '0'             not null,
  date        timestamp default CURRENT_TIMESTAMP not null,
  constraint budgets_ibfk_1
  foreign key (user_id) references users (id)
    on update cascade
    on delete cascade
)
  charset = utf8;

create index budget_product_id_index
  on budgets (product_id);

create index budget_supplier_id_index
  on budgets (supplier_id);

create index user_id
  on budgets (user_id);

create table forgotten_passwords
(
  id                          int auto_increment
    primary key,
  user_id                     int             not null,
  password_token              varchar(48)     null,
  password_last_reset         int             null
  comment 'unix timestamp of last password reset request',
  forgotten_password_attempts int default '0' not null,
  constraint forgotten_passwords_user
  unique (user_id),
  constraint forgotten_passwords_ibfk_1
  foreign key (user_id) references users (id)
    on update cascade
    on delete cascade
)
  charset = utf8;

create table notifications
(
  user_id int             not null,
  target  varchar(16)     not null
  comment 'Represents the target of the notification, like files, posts, ...etc',
  count   int default '0' not null,
  primary key (user_id, target),
  constraint notifications_users_id_fk
  foreign key (user_id) references users (id)
    on update cascade
    on delete cascade
)
  charset = utf8;

create table suppliers
(
  id               int auto_increment
    primary key,
  user_id          int                                 not null,
  title            varchar(128)                        not null,
  description      text                                not null,
  date             timestamp default CURRENT_TIMESTAMP not null,
  supplier_picture varchar(48) default 'default.png'   not null,
  email            varchar(64)                         not null,
  website          varchar(48)                         not null,
  fulfillment      int(8)                              null,
  constraint suppliers_ibfk_1
  foreign key (user_id) references users (id)
    on update cascade
    on delete cascade
)
  charset = utf8;

create table products
(
  id              int auto_increment
    primary key,
  user_id         int                                 not null,
  supplier_id     int                                 not null,
  title           varchar(62)                         not null,
  description     varchar(512)                        not null,
  product_picture varchar(48) default 'default.png'   not null,
  price_range     int                                 not null,
  delivery_days   int                                 not null,
  delivery_mean   int                                 null,
  date            timestamp default CURRENT_TIMESTAMP not null,
  constraint products_users_id_fk
  foreign key (user_id) references users (id)
    on update cascade
    on delete cascade,
  constraint products_suppliers_id_fk
  foreign key (supplier_id) references suppliers (id)
    on update cascade
    on delete cascade
)
  charset = utf8;

create table files
(
  id              int auto_increment
    primary key,
  user_id         int                                 not null,
  product_id      int                                 null,
  supplier_id     int                                 null,
  date            timestamp default CURRENT_TIMESTAMP not null,
  filename        varchar(48)                         not null
  comment 'original file name',
  hashed_filename varchar(48)                         not null
  comment 'The hashed file name generated from hash(filename . extension)',
  extension       varchar(8)                          not null
  comment 'The file extension',
  constraint files_product_id_uindex
  unique (product_id),
  constraint hashed_filename
  unique (hashed_filename),
  constraint files_users_id_fk
  foreign key (user_id) references users (id)
    on update cascade
    on delete cascade,
  constraint files_products_id_fk
  foreign key (product_id) references products (id)
    on update cascade
    on delete cascade,
  constraint files_suppliers_id_fk
  foreign key (supplier_id) references suppliers (id)
    on update cascade
    on delete cascade
)
  charset = utf8;

create index files_supplier_id_index
  on files (supplier_id);

create index files_users_id_fk
  on files (user_id);

create table orders
(
  id            int                                 not null
    primary key,
  user_id       int                                 null,
  product_id    int                                 not null,
  date_order    timestamp default CURRENT_TIMESTAMP not null,
  date_delivery int                                 not null,
  description   varchar(512)                        not null,
  status        int(1)                              not null,
  constraint orders_users_id_fk
  foreign key (user_id) references users (id)
    on update cascade
    on delete cascade,
  constraint orders_products_id_fk
  foreign key (product_id) references products (id)
    on update cascade
    on delete cascade
);

create index orders_products_id_fk
  on orders (product_id);

create index orders_users_id_fk
  on orders (user_id);

create index products_suppliers_id_fk
  on products (supplier_id);

create index products_users_id_fk
  on products (user_id);

create index user_id
  on suppliers (user_id);

INSERT INTO homestead.users (id, session_id, cookie_token, name, cpf, birthday, role, hashed_password, email, is_email_activated, email_token, email_last_verification, pending_email, pending_email_token, postal_code, country_iso, state_abbr, city, address1, address2, phone, profile_picture) VALUES (1, 'gk88qgksv3odmvnm6f8ds6t0lf', null, 'Matheus B. R. Vieira', 12345678909, 19071993, 'admin', '$2y$10$oomRp.tNyq2sG/3YE3jtMO3lyCzBwI3dxWxEsz956a7Cherfp7h4K', 'matheusrv@email.com', 1, null, null, null, null, 32604128, 'BR', 'MG', 'Betim', 'Rua Geraldo E. Coalres', 'Nº135', 31971363875, 'default.png');
INSERT INTO homestead.users (id, session_id, cookie_token, name, cpf, birthday, role, hashed_password, email, is_email_activated, email_token, email_last_verification, pending_email, pending_email_token, postal_code, country_iso, state_abbr, city, address1, address2, phone, profile_picture) VALUES (2, null, null, 'Admin Tester', 12345678901, 1012000, 'admin', '$2y$10$oomRp.tNyq2sG/3YE3jtMO3lyCzBwI3dxWxEsz956a7Cherfp7h4K', 'admin@demo.com', 1, null, null, null, null, 33222, 'US', 'FL', 'Boca Raton', '8ST Apto 320', null, 5018594565, 'default.png');
INSERT INTO homestead.users (id, session_id, cookie_token, name, cpf, birthday, role, hashed_password, email, is_email_activated, email_token, email_last_verification, pending_email, pending_email_token, postal_code, country_iso, state_abbr, city, address1, address2, phone, profile_picture) VALUES (3, null, null, 'Supply Tester', 12345678902, 1012000, 'user', '$2y$10$oomRp.tNyq2sG/3YE3jtMO3lyCzBwI3dxWxEsz956a7Cherfp7h4K', 'supplier@demo.com', 1, null, null, null, null, 29163652, 'BR', 'ES', 'Serra', 'Rua dos Pandas do Norte', 'Nº 819 - Bairro Cidade Contimental', 2728882819, 'default.png');
INSERT INTO homestead.budgets (id, user_id, product_id, supplier_id, description, status, date) VALUES (1, 1, 0, 0, 'Conta de Luz', '0', '2018-06-24 08:23:12');
INSERT INTO homestead.budgets (id, user_id, product_id, supplier_id, description, status, date) VALUES (2, 1, null, null, 'Conta de Agua', '0', '2018-06-26 06:28:54');
INSERT INTO homestead.jobs (id, description, data_job, user_id) VALUES (1, 'Juaquina da Silveira Neto Filho', '2018-06-26 13:58:30', 0);
INSERT INTO homestead.jobs (id, description, data_job, user_id) VALUES (2, 'Arlindo Cruz da Silva Maome', '2018-06-26 13:58:30', 0);
INSERT INTO homestead.suppliers (id, user_id, title, description, date, supplier_picture, email, website, fulfillment) VALUES (2, 1, 'NetCom', 'NetCom Description', '2018-06-25 22:22:05', 'default.png', 'support@netcom.com', 'http://netcom.com/', 0);
INSERT INTO homestead.suppliers (id, user_id, title, description, date, supplier_picture, email, website, fulfillment) VALUES (4, 1, 'FoxconSaaS', 'FoxconSaaS description', '2018-06-26 04:51:28', 'default.png', 'foxcon@foxcon.com', 'www.foxcon.con', null);
INSERT INTO homestead.suppliers (id, user_id, title, description, date, supplier_picture, email, website, fulfillment) VALUES (5, 1, 'NetService', 'NetService description', '2018-06-26 04:52:44', 'default.png', 'netservice@email.com', 'contact@netservice.com', null);
INSERT INTO homestead.products (id, user_id, supplier_id, title, description, product_picture, price_range, delivery_days, delivery_mean, date) VALUES (9, 1, 2, 'Product #5', 'Description about product #1', 'default.png', 1500, 7, 0, '2018-06-25 23:40:43');
INSERT INTO homestead.products (id, user_id, supplier_id, title, description, product_picture, price_range, delivery_days, delivery_mean, date) VALUES (10, 1, 2, 'Product #3', 'Description about product #2', 'default.png', 3700, 27, null, '2018-06-26 04:24:30');
INSERT INTO homestead.products (id, user_id, supplier_id, title, description, product_picture, price_range, delivery_days, delivery_mean, date) VALUES (11, 1, 4, 'Product #1', 'Description of product #1', 'default.png', 250, 1, null, '2018-06-26 04:53:30');
INSERT INTO homestead.products (id, user_id, supplier_id, title, description, product_picture, price_range, delivery_days, delivery_mean, date) VALUES (12, 1, 5, 'Product #1', 'Product Description', 'default.png', 564656, 150, null, '2018-06-26 04:54:01');
