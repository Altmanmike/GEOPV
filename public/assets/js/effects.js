// Script entier en mode strict
//"use strict";

const ratio = 0.1
const options = {
  root: null,
  rootMargin: '0px',
  threshold: ratio
}

const handleIntersect = function (entries, observer) {
    entries.forEach(function (entry) {
        if (entry.intersectionRatio > ratio) {            
            entry.target.classList.add('slide-in-fwd-visible')
            observer.unobserve(entry.target)
        }
    })   
}

const observer = new IntersectionObserver(handleIntersect, options)

document.querySelectorAll('[class*="slide-in-fwd-"]').forEach(function (rev) {
observer.observe(rev)})