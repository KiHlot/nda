import { fetchData } from "./helpers/_api.js";

const disabledButtons = (widget, disabled) => {
  if (!widget) {
    return;
  }

  const buttons = widget.querySelectorAll("button");
  buttons?.forEach((btn) => (btn.disabled = disabled));
};

const handleClick = async (event) => {
  const button = event.currentTarget;
  const widget = button.closest(".likes_widget");

  if (!widget || button.disabled) {
    return;
  }

  const countElement = widget.querySelector(".count");

  if (!countElement) {
    return;
  }

  const postId = widget.dataset.postId;
  const type = button.dataset.type;

  if (!postId || !type) {
    return;
  }

  const currentCount = parseInt(countElement.textContent) || 0;
  const buttons = widget.querySelectorAll("button");
  let previousStates = {};

  buttons.forEach((btn) => {
    previousStates[btn.dataset.type] = btn.disabled;
  });

  previousStates = { ...previousStates, currentCount };

  countElement.textContent =
    type === "increment" ? currentCount + 1 : currentCount - 1;

  disabledButtons(widget, true);

  try {
    const formData = new FormData();
    formData.append("postId", postId);
    formData.append("type", type);
    formData.append("pageUrl", window.location.href);

    const result = await fetchData(formData);

    const { data, errors } = result || {};

    if (data === undefined) {
      buttons.forEach((btn) => {
        btn.disabled = previousStates[btn.dataset.type] || false;
      });

      countElement.textContent = previousStates.currentCount;
      console.error(errors?.code || 'Ошибка сервера');
      return;
    }

    countElement.textContent = data.count;

    buttons.forEach((btn) => {
      btn.disabled = btn.dataset.type === data.disabledType;
    });
  } catch (error) {
    buttons.forEach((btn) => {
      btn.disabled = previousStates[btn.dataset.type] || false;
    });

    countElement.textContent = previousStates.currentCount;
    console.error("Ошибка обновления лайков:", error);
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
