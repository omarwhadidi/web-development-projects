const UserModel = require('../models/UserModel.conf')
const GroupModel = require('../models/GroupModel.conf');
const bcrypt = require('bcrypt') 


 module.exports.loginpage = (req, res) => {

    //res.send('Home page')
    //res.sendFile('index.html')
    res.render('index.ejs' , {usererror: req.flash('usererror') , passerror: req.flash('passerror') , inserted: req.flash('inserted')})

}

module.exports.signin = async (req, res) => {

    const {username,password} = req.body
    
    //console.log(req.body)
    
    let user = await UserModel.findOne({username})
    if (user !== null){
        
        const match = await bcrypt.compare(password, user.password);
        if(match){
            //console.log('logged in successfull')
            var hour = 3600000
            //req.session.cookie.expires = new Date(Date.now() + hour) Method 1
            req.session.cookie.maxAge = hour // Method 2
            req.session.UserId = user._id,
            req.session.username = user.username,
            req.session.IsLoggedIn = true

            let permissions = await GroupModel.findOne({username})
            if (permissions.group_number == 2){

                req.session.IsAdmin = true
                res.redirect('/admin')
            }
            else {

                res.redirect('/home')

            }
                    
        }
        else {
            //console.log('incorrect password')
            req.flash('passerror' , true)
            res.redirect('/')
        }

    }
    else {
        req.flash('usererror' , true)
        res.redirect('/')
    }
    
}