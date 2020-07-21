<!DOCTYPE html>
<html>
<head>
  <title>
    Book Management System(BMS)
  </title>
</head>
<body>
  <p>
    you have {{$desc ?? ''}} following book
  </p>
  <strong>
    Name:
  </strong>
  {{$book->name ?? ''}}
  <br>
  <strong>
    Author
  </strong>
  {{$book->author ?? ''}}
</br>
</body>
</html>
