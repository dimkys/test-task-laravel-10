const input = document.getElementById('link');
const button = document.getElementById('submit');
const resultLabel = document.getElementById('result');

const postTarget = button.dataset.target;
const fetchTarget = button.dataset.lastShorts;
const token = button.dataset.token;

let history = document.querySelector('.last-shorts');

const updateList = () => {
    fetch(fetchTarget, {
        method: 'GET',
    }).then((response) => {
        if (response.status === 200) {
            response.text().then((data) => {
                history.innerHTML = data;
            });
        }
        button.disabled = false;
    });
}

button.addEventListener('click', () => {
    if (input.value) {
        button.disabled = true;
        fetch(postTarget, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({'_token': token, 'link': input.value})
        }).then((response) => {
            if (response.status === 200) {
                updateList();
                input.value = '';
                try {
                    response.json().then((data) => {
                        if (data.short) {
                            resultLabel.innerText = data.short;
                        }
                    });
                } catch (e) {
                    alert('All broken(');
                }
            } else if (response.status === 400) {
                try {
                    response.json().then((data) => {
                        if (data.error) {
                            alert(data.error);
                        }
                    });
                } catch (e) {
                    alert('All broken(');
                }
                button.disabled = false;
            }
        });
    }
});

resultLabel.addEventListener('click', () => {
    try {
        navigator.clipboard.writeText(resultLabel.textContent).then(console.log);
        console.log('Content copied to clipboard');
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
});
