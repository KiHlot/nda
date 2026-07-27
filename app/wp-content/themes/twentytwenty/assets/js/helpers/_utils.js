export const toggleBodyOverflow = (isAdd) => {
  if (isAdd) {
    document.body.classList.add("ovh");
  } else {
    document.body.classList.remove("ovh");
  }
};
