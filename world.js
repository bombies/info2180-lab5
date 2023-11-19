let DOM_LOADED = false;
const queuedJobs = [];

document.addEventListener('DOMContentLoaded', () => {
    DOM_LOADED = true;
    while (queuedJobs.length)
        queuedJobs.pop()();
});

const work = (job) => {
    if (DOM_LOADED)
        return job();
    queuedJobs.push(job);
}

work(() => {
    const lookupButton = document.getElementById("lookup");
    const countryInput = document.getElementById("country");

    lookupButton.addEventListener("click", async () => {
        try {
            const search = countryInput.value
            console.log(search)
            const res = await fetch(`world.php?${new URLSearchParams({country: search})}`)
            const html = await res.text()

            const resultDiv = document.getElementById("result")
            resultDiv.innerHTML = html
        } catch (e) {
            console.error(e)
        }
    })
})