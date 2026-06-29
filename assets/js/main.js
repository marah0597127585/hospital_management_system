document.querySelectorAll('.delete-form').forEach(f=>f.addEventListener('submit',e=>{if(!confirm('هل أنت متأكد من الحذف؟'))e.preventDefault()}));
