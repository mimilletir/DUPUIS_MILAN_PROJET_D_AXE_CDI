function SetActive()
{
  var pageurl = location.href;
  var dnl = document.getElementsByTagName("a");
  for(i = 0; i < dnl.length;i++)
  {
    var x = dnl.item(i);
    x.classList.remove("active")
    if(x.href == pageurl)
    {
      x.classList.add("active")
    }
  }	
}

SetActive();