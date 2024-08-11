const calendarTable = document.getElementById("calendar-table").getElementsByTagName("tbody")[0];
const monthYearText = document.getElementById("month-year");
const prevMonthButton = document.getElementById("prev-month");
const nextMonthButton = document.getElementById("next-month");

let currentDate = new Date();
let cutiData = [];

// Fetch data cuti dari server
fetch("get_cuti.php")
  .then((response) => response.json())
  .then((data) => {
    console.log("Data cuti:", data);
    cutiData = data;
    renderCalendar(currentDate);
  });

function renderCalendar(date) {
  const month = date.getMonth();
  const year = date.getFullYear();
  monthYearText.textContent = `${date.toLocaleString("default", { month: "long" })} ${year}`;

  calendarTable.innerHTML = "";

  const firstDayOfMonth = new Date(year, month, 1).getDay();
  const lastDateOfMonth = new Date(year, month + 1, 0).getDate();

  let row = document.createElement("tr");

  for (let i = 0; i < firstDayOfMonth; i++) {
    const cell = document.createElement("td");
    row.appendChild(cell);
  }

  for (let day = 1; day <= lastDateOfMonth; day++) {
    if (row.children.length === 7) {
      calendarTable.appendChild(row);
      row = document.createElement("tr");
    }

    const cell = document.createElement("td");
    cell.textContent = day;

    // Cek apakah ada cuti di tanggal ini
    const tanggal = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;

    cutiData.forEach((cuti) => {
      const startDate = new Date(cuti.tanggal_mulai);
      const endDate = new Date(cuti.tanggal_selesai);
      const currentDate = new Date(tanggal);

      if (currentDate >= startDate && currentDate <= endDate) {
        const nameSpan = document.createElement("span");
        nameSpan.textContent = `\n${cuti.nama}`;
        nameSpan.style.display = "block";
        nameSpan.style.color = "blue";
        cell.appendChild(nameSpan);
      }
    });

    const today = new Date();
    if (year === today.getFullYear() && month === today.getMonth() && day === today.getDate()) {
      cell.classList.add("today");
    }

    row.appendChild(cell);
  }

  calendarTable.appendChild(row);

  while (row.children.length < 7) {
    const emptyCell = document.createElement("td");
    row.appendChild(emptyCell);
  }
}

prevMonthButton.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar(currentDate);
});

nextMonthButton.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar(currentDate);
});

// Initial render
renderCalendar(currentDate);
