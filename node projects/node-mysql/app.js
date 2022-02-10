// npm init -y
// npm i  express ejs mysql2 bcrypt  express-session [express-validator connect-flash ]   --save
// visual Studio code : Material Icon Theme / ExpressSnippet

const express = require("express")
const app = express()
const query = require('./db/db.conf.js')   // include database file
const path = require('path')

const port = 3002

var session = require('express-session')
app.use(session({
    secret :'encryption key here' ,
    resave: false ,
    saveUninitialized : false ,
 }))
 var flash = require('connect-flash')

 app.use(express.json())             // allow receiving json data from browser
 app.use(express.urlencoded({extended : false }))    // allow receiving form data from browser
 app.use(express.static(path.join(__dirname,'public')))
 app.set('view engine', 'ejs');
 app.use(flash())

app.use(require('./routes/signup.routes.js'))     // include signup file
app.use(require('./routes/signin.routes.js'))     // include signin file
app.use(require('./routes/admin.routes.js'))     // include admin file
app.use(require('./routes/user.routes.js'))     // include admin file
app.use(require('./routes/update.routes.js'))     // include admin file
app.use(require('./routes/posts.routes.js'))     // include post file


app.get('/',(req,res) => {
    res.render("index.ejs", {inserted: req.flash('inserted') , passerror: req.flash('passerr') , usererror: req.flash('usererr') })
})




app.listen(port, ()=> {
    console.log("server is running");
})  