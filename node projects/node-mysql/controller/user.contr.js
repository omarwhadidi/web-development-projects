const query = require('../db/db.conf.js')   // include database file


module.exports.homepage = (req,res) => {

    if(req.session.isLoggedIn){

        let sessiondata = req.session

        query.execute(`select * FROM posts order by Date DESC`, (err,data) => {
    
            res.render("home.ejs",{data,sessiondata})
        }) 

    }   
    else {
        res.redirect('/')
    }
    

}

module.exports.profilepage = (req,res) => {

    if(req.session.myID){

        let sessiondata = req.session

        query.execute(`select * FROM posts WHERE username = '${req.session.username}' order by Date DESC`, (err,data) => {
    
            res.render("profile.ejs",{data,sessiondata}) 
        }) 

    }   
    else {
        res.redirect('/')
    }
    

}

module.exports.searchpost = (req,res) => {      // search using query

    let name = req.query.userpost ;
    let sessiondata = req.session
    query.execute(`select * FROM posts WHERE username LIKE '%${name}%'`, (err,data) => {

        //res.json(data)
        res.render("home.ejs",{data,sessiondata})
    }) 
    
}

module.exports.addpost = (req,res) => {
    console.log(req.body);
    let sessiondata = req.session
    let post = req.body.userpost;
    query.execute(`INSERT INTO posts (username,post) VALUES ('${sessiondata.username}','${post}')`) 
    
    res.json({message: "Post Added Successfully"})
    //res.render("home.ejs",{data,sessiondata})
}

module.exports.deletepost = (req,res) => {
    console.log(req.body);
    let id = req.body.postid ;
    let sessiondata = req.session
    query.execute(`DELETE FROM posts where post_id = '${id}' && username = '${sessiondata.username}'`,  (err,data) => {

        //res.json(data)
        res.redirect('/profile')
    }) 

}


module.exports.logout = (req,res) => {
    
    if(req.session.myID){
        req.session.destroy(()=>{
            res.redirect('/')
        })    
    }
    else {
        res.redirect('/')
    }

}