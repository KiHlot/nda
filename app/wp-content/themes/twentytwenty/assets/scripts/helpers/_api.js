export const fetchData = async (formData) => {
  try {
    const response = await fetch("/wp-json/rest/likes-widget", {
      method: "post",
      body: formData,
    });
    return await response.json();
  } catch (error) {
    console.error(error);
  }
};
