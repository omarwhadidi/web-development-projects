const query = require('../db/db.conf.js')  


module.exports.updatepage = (req,res) => {

    if(req.session.isLoggedIn){

        let sessiondata = req.session

        query.execute(`select * FROM users WHERE username = '${sessiondata.username}' `, (err,data) => {
    
            res.render("update.ejs",{ data, sessiondata,updated: req.flash('updated')})

        }) 

    }   
    else {
        res.redirect('/')
    }

}

module.exports.edituserinfo = (req,res) => {

    console.log(req.body);

        const {firstname,lastname,email,password,password2} = req.body

        let usersession = req.session.username

        if (typeof firstname !== 'undefined' && firstname !='') {
           
            query.execute(`UPDATE users SET firstname = '${firstname}' WHERE username = '${usersession}' `)
            
        }
        if (typeof lastname !== 'undefined' && lastname !='') {
         
            query.execute(`UPDATE users SET lastname = '${lastname}' WHERE username = '${usersession}' `)
            
        }
        if (typeof email !== 'undefined' && email !='') {
        
            query.execute(`UPDATE users SET email = '${email}' WHERE username = '${usersession}' `)
        
        }
        if (typeof password !== 'undefined' && password !='') {
        
            if (password ==  password2) {

                query.execute(`UPDATE users SET password = '${password}' WHERE username = '${usersession}' `)

            }
        }
        req.flash('updated' , true)
        res.redirect('/UpdateUserInfo')


}