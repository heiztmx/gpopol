var express = require('express')
var http = require('http')
var app = express()

app.get('/', (req, res) => {
  res.status(200).send("Welcome to API REST")
})

http.createServer(app).listen(8001, () => {
  console.log('Server started at http://localhost:8001');
});