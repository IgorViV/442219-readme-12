-- list of content types for the post
INSERT INTO types (title, alias)
VALUES
  ('Фото', 'photo'),
  ('Видео', 'video'),
  ('Текст', 'text'),
  ('Цитата', 'quote'),
  ('Ссылка', 'link');

-- adding users
INSERT INTO users (email, user_name, user_password, avatar_url)
VALUES
  ('larisa@mail.ru', 'Лариса', 'larisapassword', 'userpic-larisa-small.jpg'),
  ('vlad99@mail.ru', 'Владик', 'vlad99password', 'userpic.jpg'),
  ('victory@mail.ru', 'Виктор', 'victorypassword', 'userpic-mark.jpg'),
  ('mark@mail.ru', 'Максим', 'maksimpassword', 'userpic.jpg'),
  ('anna@mail.ru', 'Анна', 'annapassword', 'userpic-larisa-small.jpg');

-- adding posts;
INSERT INTO posts (title, text_content, author_quote, img_url, video_url, site_url, view_counter, user_id, type_id)
VALUES
  ('Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Неизвестный', NULL, NULL, NULL, 2, 1, 4),
  ('Игра престолов', 'Не могу дождаться, начала финального сезона своего любимого сериала!', NULL, NULL, NULL, NULL, 10, 2, 3),
  ('Наконец, обработал фотки!', NULL, NULL, 'rock-medium.jpg', NULL, NULL, 18, 3, 1),
  ('Моя мечта', NULL, NULL, 'coast-medium.jpg', NULL, NULL, 34, 1, 1),
  ('Лучшие курсы', NULL, NULL, NULL, NULL, 'www.htmlacademy.ru', 55, 2, 5),
  ('Лучший подкаст', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=NuOTVGT6gVk&list=PLMBnwIwFEFHcwuevhsNXkFTcadeX5R1Go', NULL, 8, 4, 2),
  ('Доклад интрига', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=nIFClfBXuIQ&list=RDCMUCTUyoZMfksbNIHfWJjwr5aQ&index=2', NULL, 12, 5, 2);

-- adding comments;
INSERT INTO comments (content, author_id, post_id)
VALUES
  ('Потрясающий доклад, оставил глубокое впечатление.', 2, 7),
  ('Фотки класс!', 5, 3),
  ('Фотки класс! Впечатлил...', 1, 3);

-- adding likes;
INSERT INTO likes (user_id, post_id)
VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4),
  (5, 5),
  (1, 2),
  (2, 3),
  (3, 4),
  (4, 4),
  (5, 6),
  (1, 3),
  (2, 4),
  (3, 5),
  (4, 6),
  (5, 7),
  (4, 7),
  (3, 7),
  (2, 7),
  (1, 7);

-- get a list of posts sorted by popularity and along with the names of the authors and the type of content:
SELECT COUNT(likes.id) like_count, posts.title, user_name AS author, types.title AS type_content
  FROM posts
  JOIN  users ON posts.user_id = users.id
  JOIN types ON posts.type_id = types.id
  JOIN likes ON posts.id = likes.post_id
  GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;

-- get a list of posts for a specific user:
SELECT title
  FROM posts
  WHERE posts.user_id = 5;

-- get a list of comments for one post (the user's login must be in the comments):
SELECT comments.content comment, users.user_name
  FROM comments
  JOIN users ON comments.author_id = users.id
  WHERE comments.post_id = 3;

-- add a like to a post:
INSERT INTO likes SET user_id = 2, post_id = 5;

-- subscribe to a user:
INSERT INTO subscriptions (author_id, subscriber_id)
VALUES
(1, 5),
(1, 3),
(1, 2),
(2, 4),
(3, 2),
(3, 1),
(3, 4),
(4, 3),
(5, 1);
