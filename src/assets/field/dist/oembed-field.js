//
// Docs: https://github.com/craftcms/cms/blob/develop/src/web/assets/cp/src/js/Craft.js
//

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
        options: {
          maxwidth: 1000
        },
        providers: this._providers
      }
    }).then((res) => {
      if(res.data.success) {
        const div = document.createElement('div');
        div.innerHTML = res.data.data.html || '';
        this._root.style.setProperty('--width', res.data.data.width);
        this._root.style.setProperty('--height', res.data.data.height);
        this._root.classList.add('has-embed');
        this._root.replaceChildren(div);
      } else {
        this._root.classList.remove('has-embed');
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
