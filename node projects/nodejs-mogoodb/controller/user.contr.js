const UserModel = require('../models/UserModel.conf')
const PostModel = require('../models/PostModel.conf')


 module.exports.homepage = async (req, res) => {
    
    if (req.session.IsLoggedIn){
        
        let data = await PostModel.find().sort({post_date:-1})
        let sessiondata = req.session

        res.render('home.ejs' , {data , sessiondata})
    }
    else {
        res.redirect('/')
    }
    

}

module.exports.profilepage = async (req, res) => {
    
    if (req.session.IsLoggedIn){
        
        let sessiondata = req.session
        let userprofile = sessiondata.username
        let data = await PostModel.find({username : userprofile}).sort({post_date:-1})
        

        res.render('profile.ejs' , {data , sessiondata})
    }
    else {
        res.redirect('/')
    }
    
}

module.exports.searchpost = async (req, res) => {
    
    if (req.session.IsLoggedIn){
        
        let name = req.query.userpost ;
        let sessiondata = req.session

        let data = await PostModel.find({username : {'$regex': name}}).sort({post_date:-1})
        
        res.render('home.ejs' , {data , sessiondata})
    }
    else {
        res.redirect('/')
    }
    
}

module.exports.addpost = async (req, res) => {
    
    if(req.session.IsLoggedIn){

        let userprofile = req.session.username
        let post = req.body.userpost;
        let newDate = new Date();

        await PostModel.insertMany({
            
            username: userprofile,
            post: post,
            post_date: newDate

        })
        res.redirect('/home')
    
    }
    else {
        res.redirect('/')
    }
    
}

module.exports.deletepost = async (req, res) => {
    
    if(req.session.IsLoggedIn){

        let userprofile = req.session.username
        let post_id = req.body.postid;

        await PostModel.deleteOne({
            
            _id : post_id,
            username: userprofile,

        })
        res.redirect('/profile')
    
    }
    else {
        res.redirect('/')
    }
    
}

module.exports.logout = async (req, res) => {
    
    if(req.session.IsLoggedIn){

        req.session.destroy(()=>{
            res.redirect('/')
        })    
    }
    else {
        res.redirect('/')
    }
    
}