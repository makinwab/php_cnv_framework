if(typeof jQuery != 'undefined')
{
    $(function(){
       $('.del').click(function()
       {
          if(!confirm("Are you sure?"))
          {
              return false;
          }
       });
    });
}
