function slug_generator() {
  let slug = document.getElementById('product').value;
  slug = slug.split(' ').join('-');
  document.getElementById('slug').value = slug;
}