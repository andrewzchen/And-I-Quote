// Use the WikiQuoteApi module to get a list of up to 10 quotes from user's search

function randomQuoteCall(title) {
  WikiquoteApi.openSearch(title, function(results) {
     console.log(results);
     WikiquoteApi.getRandomQuote(results[0], function(newQuote) {
       console.log(newQuote);
    //   $("#quote").text(newQuote.quote);
       displayResults(newQuote);

     },
     function(msg) {
       alert(msg);
     }
   );
 }, function(msg) {
   alert(msg);
 }
);
}

function displayResults(resultObject) {
  var numQuotes = 0;
  let row = document.querySelector(".resultRow");
  while (row.hasChildNodes()) {
    row.removeChild(row.lastChild);
  }
//  for (let i = 0; i < 1; i++) {
  for (let i = 0; i < resultObject.quote.length; i++) {
    if (resultObject.quote[i].trim().length == 0) {
      // sometimes get a blank quote, just skip in that case
      continue;
    }
    // if we
    if (numQuotes > 10) {
      break;
    }
    let colDiv = document.createElement("div");
    // colDiv.classList.add("col-6 col-md-4 col-lg-3 mt-4");
    colDiv.classList.add("col-11", "mt-2");
    row.appendChild(colDiv);
    let quoteDescription = document.createElement("p");
    quoteDescription.classList.add("lead");
  //  let newString = formatString(resultObject.quote[i]);
    quoteDescription.innerHTML = resultObject.quote[i];
//    quoteDescription.innerHTML = resultObject.quote;
    console.log(quoteDescription);
    colDiv.appendChild(quoteDescription);
    let heartDiv = document.createElement("div");
    heartDiv.classList.add("col-1");
    row.appendChild(heartDiv);
    let heartIcon = document.createElement("i");
    heartIcon.classList.add("fa");
    heartIcon.classList.add("fa-heart");
    heartIcon.style.color = "white";
    heartIcon.addEventListener("click", function () {
      if (this.style.color == "white") {
        this.style.color = "black";
        location.href = "favorites_confirm.php?quote=" + resultObject.quote[i];
      }
      // else {
      //   this.style.color = "white";
      // }
    });
    heartDiv.appendChild(heartIcon);
    numQuotes++;
  }
}
randomQuoteCall($("#search").val());

// $(".fa-heart").on("click", function() {
//   console.log("fat cok");
//   if ($(this).style.color == "white") {
//     $(this).style.color = "black";
//   }
//   else {
//     $(this).style.color = "white";
//   }
// });
// $(document).onload(function() {
//   randomQuoteCall($("#search").val());
// });
