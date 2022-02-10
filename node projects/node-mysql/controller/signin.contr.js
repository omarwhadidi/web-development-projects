const query = require('../db/db.conf.js')   // include database file
const bcrypt = require('bcrypt');
const { set } = require("mongoose");
const session = require("express-session");


module.exports.SignIn =  (req, res) => {
    //console.log(req.body);
    const {username,password} = req.body
    
     query.execute(`select * FROM users WHERE username = '${username}' `,  (err, data) => {
             
            
            if (data.length == 1) {

                //console.log(data.id);
                //console.log('user found');
                // const match =  await bcrypt.compare(password == data[0].password);
                // console.log(match);

                 if (password == data[0].password) {
                    
                    var hour = 3600000
                    //req.session.cookie.expires = new Date(Date.now() + hour) Method 1
                    req.session.cookie.maxAge = hour // Method 2
                    req.session.myID = data[0].id
                    req.session.username = data[0].username
                    req.session.isLoggedIn = true
                    req.session.isAdmin = false
                    //console.log('password match');
                    if (username == 'admin'){
                        req.session.isLoggedIn = true
                        req.session.isAdmin = true
                        res.redirect('/admin');
                    }
                    else {
                        res.redirect('/home');
                    }
                    
                 }
                 else {
                     //console.log('password Doesnt match');
                     req.flash('passerr' , true)
                     res.redirect('/');
                 }
            }
            else {
                // console.log('NO User Found');
                 req.flash('usererr' , true)
                 res.redirect('/');
            }
         }) 
  
   
}