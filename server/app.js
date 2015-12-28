var express = require('express');
var cors = require('cors'); // https://github.com/expressjs/cors
var bodyParser = require('body-parser');
var multer  = require('multer');
var Sequelize = require('sequelize'); // http://sequelize.readthedocs.org/en/latest/
var mysql = require('mysql'); // https://github.com/felixge/node-mysql
var app = express();

app.use( cors() );
app.use( bodyParser.json() ); // for parsing application/json
app.use( bodyParser.urlencoded({ extended: true }) ); // for parsing application/x-www-form-urlencoded

app.get('/', function(req, res) {
	res.send('Hello World!');
});

app.post('/register', function(req, res) {

	var first = req.body.first,
		last = req.body.last,
		email = req.body.email,
		pass = req.body.password;

	var con = connect();
	con.query(
		"INSERT INTO users (first, last, email, password) VALUES ('"+ first +"','"+ last +"','"+ email +"','"+ pass +"')",
		function( err, rows ) {
			if( err ) {
				console.log( err );
			}
		}
	);
});

app.listen(3000, function(){
	console.log('CORS-enabled web server listening on port 3000');
});

function connect() {
	var con = mysql.createConnection({
	  host: 'localhost',
	  user: 'root',
	  password: 'password',
	  database: 'now'
	});

	con.connect(function(err){
	  if(err){
	    console.log('Error connecting to Db');
	    return;
	  }
	  console.log('Connection established');
	});

	return con;
}