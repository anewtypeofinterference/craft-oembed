var ANTI = ANTI || {};

class oEmbedPreview {
  constructor(root, input, providers = []) {
    if(!(root instanceof Element) || !(input instanceof HTMLInputElement)) {
      throw 'oEmbedPreview requires a root element and input element';
    }

    this._root = root;
    this._input = input;
    this._providers = providers;
    this._onChangeHandler = this._onChange.bind(this);
    // TODO: Consider adding debounce
    this._input.addEventListener('change', this._onChangeHandler, false);
  }

  _onChange(evt) {
    Craft.sendActionRequest('POST', 'oembed/data/get-data', {
      data: {
        url: evt.target.value,
        providers: this._providers
      }
    }).then((res) => {
      if(res.data.success) {
        this._root.replaceChildren(res.data.data.html);
      } else {
        const ul = document.createElement('ul');
        ul.classList.add('errors');
        const li = document.createElement('li');
        li.innerText = res.data.message;
        ul.appendChild(li);
        this._root.replaceChildren(ul);
      }
    });
  }
}

ANTI.oEmbedPreview = oEmbedPreview;
