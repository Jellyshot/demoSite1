function co_function(co_no){
    let tohide = "c_d_display"+co_no;
    let toshow = "c_d_hide"+co_no; 
  
    if(document.getElementById(tohide).style.display == "block"){
      document.getElementById(tohide).style.display = "none";
      document.getElementById(toshow).style.display = "block";
    }else {
      document.getElementById(tohide).style.display = "block";
      document.getElementById(toshow).style.display = "none";
    }
  }