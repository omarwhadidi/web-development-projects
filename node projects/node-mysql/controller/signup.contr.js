const { check } = require('express-validator')
const { validationResult } = require('express-validator')
const query = require('../db/db.conf.js')   // include database file
const bcrypt = require('bcrypt');



module.exports.Regpage = (req,res) => {
  //console.log(req.flash('errors'))
  res.render("register.ejs", {errors: req.flash('errors') , emailexist: req.flash('emailexist')})
}

module.exports.validation = [
    check('firstname').matches(/^[a-zA-Z ]{2,20}$/),
    check('lastname').matches(/^[a-zA-Z ]{2,20}$/),
    check('username').matches(/^[a-zA-Z0-9]{5,20}$/),
    check('email').isEmail(),
    check('password').matches(/^[a-zA-Z0-9!@#$%^&*]{6,16}$/),
    /* check('password2').custom((value, { req }) => {
        if (value !== req.body.password) {
          return false; 
        }
            return true;
    }) */
]




module.exports.SignUp = (req, res) => {
   
  //console.log(req.body);
  const {firstname,lastname,username,email,password,password2,gender} = req.body
  const errors = validationResult(req);

  if (!errors.isEmpty()) {

      //return res.status(400).json({ errors: errors.array() });
      //console.log(errors.array())
      req.flash('errors', errors.array())
      res.redirect('/register')
    }
    else {
      
      // Validtion successfull code

      if (password == password2){
          query.execute(`select * FROM users WHERE email = '${email}'`, (err, data) => {
  
             // console.log(data);
              if (data.length == 0){
                  bcrypt.hash(password, 7, function(err, hash) {
                      query.execute(`INSERT INTO users (firstname,lastname,username,email,password,gender) VALUES ('${firstname}','${lastname}','${username}','${email}','${hash}','${gender}')`)
                      query.execute(`INSERT INTO groups (username,group_id,permissions) VALUES ('${username}','0','User')`)
                      //console.log('user inserted');
                      req.flash('inserted' , true)
                      res.redirect('/')   
                  });
  
              }
              else {
                  req.flash('emailexist' , true)
                 // console.log('email exists')
                  res.redirect('/register')  
              }
          }) 
  
      }
      else {
          console.log("password Doesnt match")
          res.redirect('/register')
      }


    }

 
}

