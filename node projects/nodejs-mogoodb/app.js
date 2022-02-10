// npm init -y
/* // npm i  
            express 
            ejs 
            mongodb 
            bcrypt  
            [express-session connect-mongodb-session ]
            [express-validator connect-flash ]   --save 
            
 when hosting on external server:
  1- Add this to package.json
        "scripts": {
            "test": "echo \"Error: no test specified\" && exit 1",
            "start": "node app.js"    // name of the main application
        },
        "engines": {"node":"14.15.4"},  
    2- change the app.listen and add this line "process.env.PORT ||" :
        app.listen(process.env.PORT || port, () => {
            console.log('App listening on port 3003!');
        });
    3- create/host a database online on mongodb website
            
            */
            
// visual Studio code : Material Icon Theme / ExpressSnippet

const express = require('express')
const app = express()
let PORT = process.env.PORT || 3002;
const mongoose = require("mongoose")
mongoose.connect('mongodb://localhost:27017/myapp',{ useNewUrlParser: true , useUnifiedTopology: true ,useCreateIndex: true});


var session = require('express-session')
var MongoDBStore = require('connect-mongodb-session')(session);
var store = new MongoDBStore ({
    uri : 'mongodb://localhost:27017/myapp',  // same uri as the one used to connect to mongodb
    collection : 'mySessions'  // name of the collection that will store the sessions
 })
app.use(session({
    secret :'encryption key here' ,
    resave: false ,
    saveUninitialized : false ,
    store
 }))
 var flash = require('connect-flash')


const path = require('path')
app.use(express.static(path.join(__dirname,'public')))
app.use(express.json())
app.use(express.urlencoded({ extended : false }))
app.set("view engine","ejs")
app.use(flash())


app.use(require('./routes/signup.routes'))
app.use(require('./routes/signin.routes'))
app.use(require('./routes/user.routes'))
app.use(require('./routes/admin.routes'))
app.use(require('./routes/update.routes'))


app.get('*', (req, res) => {
    res.render('404.ejs')
});



app.listen(PORT, () => {
    console.log(`App listening on port ${PORT}`);
});