const wpAjaxUrl = ajax_var.url;

export const fetchData = async (formData) => {
  try {
    const response = await fetch(wpAjaxUrl, {
      method: "post",
      body: formData,
    });
    return await response.json();
  } catch (error) {
    console.error(error);
  }
};
