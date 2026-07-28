import { fetchData } from "./helpers/_api.js";

const handleClick = async (event) => {
  const button = event.currentTarget;
  const widget = button.closest(".likes_widget");


  
  if (!widget) {
    return;
  }

  const countElement = widget.querySelector(".count");
  const postId = widget.dataset.postId;
  const type = button.dataset.type;

  if (!countElement) {
    return;
  }

  let currentCount = parseInt(countElement.textContent) || 0;

  countElement.textContent =
    type === "increment" ? currentCount + 1 : Math.max(0, currentCount - 1);

  if (postId) {
    try {
      const formData = new FormData();
      formData.append("postId", postId);
      formData.append("type", type);
      formData.append("action", "likes_widget");

      console.log("formData", formData);
      
      const data = await fetchData(formData);

      if (data?.count) {
        countElement.textContent = data.count;
      }
    } catch (error) {
      countElement.textContent = currentCount;
      console.error("Ошибка обновления лайков:", error);
    }
  }
};

export const _initLikesWidget = async () => {
  const widgets = document.querySelectorAll(".likes_widget");

  if (!widgets.length) {
    return;
  }

  for (const widget of widgets) {
    const buttons = widget.querySelectorAll("button");

    for (const button of buttons) {
      button.removeEventListener("click", handleClick);
      button.addEventListener("click", handleClick);
    }
  }
};
