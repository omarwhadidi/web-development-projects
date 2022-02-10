const PostRouter = require("express").Router()
const query = require('../db/db.conf.js')   // include database file




PostRouter.get('/GetPosts',(req,res) => {

    query.execute(`select * FROM posts `, (err,data) => {

        res.json(data)
        res.render("home.ejs",{data})
    })  

    
})

PostRouter.get('/GetPost/:user',(req,res) => {   // search using params

    query.execute(`select * FROM posts WHERE username = '${req.params.user}'`, (err,data) => {

        //res.json(data)
        res.render("home.ejs",{data})
    }) 
    
})



PostRouter.post('/EditPost',(req,res) => {
    console.log(req.body);
    let id = req.body.postid ;
    query.execute(`select * FROM posts WHERE post_id = '${id}' `, (err,data) => {

        res.render("updatepost.ejs",{data})
    }) 

})

PostRouter.post('/UpdatePost',(req,res) => {
    console.log(req.body);
    let id = req.body.postid ;
    let post = req.body.newpost ;
    query.execute(`UPDATE posts SET post = '${post}' WHERE post_id = '${id}' `) 
    
    //res.json({message: "post  updated Successfully"})
    res.redirect('/dashboard')
})




module.exports = PostRouter