const {check  } = require('express-validator')

module.exports.validation = [ 
check('firstname').matches(/^[a-zA-Z]{2,20}$/),
check('lastname').matches(/^[a-zA-Z]{2,20}$/),
check('username').matches(/^[a-zA-Z0-9]{4,20}$/),
check('email').isEmail().trim().escape().normalizeEmail(),
check('password').isLength({ min: 8 }).withMessage('Password Must Be at Least 8 Characters').matches('[0-9]').withMessage('Password Must Contain a Number').matches('[A-Z]').withMessage('Password Must Contain an Uppercase Letter').trim().escape(),
check('password2').custom((value, { req }) => {
    if (value !== req.body.password) {
      return false; 
    }
        return true;
})
]