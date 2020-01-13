insert into `users` (
    `name`,
    `email`,
    `password`,
    `birthday`,
    `is_admin`
)
values (
    'test1',
    'gt.4.pff.gi@gmail.com',
    '$2y$10$eSePpwz2hteTQZNXO1BvFeI.VCSGF/YqGdpZda/sHQDQWzAJoehYi', -- パスワード test1
    '1986-01-27',
    '1'
),
(
    'test2',
    'fgx0021@gmail.com',
    '$2y$10$btIzYtozzeEJ2J53ZU/Qz.YBK61RilXtGcVJkrZfz1r/fS8R72F.i', -- パスワード test2
    '1985-07-07',
    '0'
);
