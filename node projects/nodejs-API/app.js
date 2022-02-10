// npm init -y
/* // npm i  
            express 
            ejs 
            mongodb 
            jsonwebtoken
            bcrypt  
            express-validator   --save 
            
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
let PORT = process.env.PORT || 3003;
const mongoose = require("mongoose")
mongoose.connect('mongodb://localhost:27017/myapp',{ useNewUrlParser: true , useUnifiedTopology: true ,useCreateIndex: true});
const cors = require('cors')

app.use(express.json())
app.use(cors())
app.set("view engine","ejs")


app.use(require('./routes/signup.routes'))
app.use(require('./routes/signin.routes'))
app.use(require('./routes/user.routes'))
app.use(require('./routes/admin.routes'))
app.use(require('./routes/update.routes'))


app.get('*', (req, res) => {
    res.send('not found page 404')
});


app.listen(PORT, () => {
    console.log('App listening on port 3003!');
});