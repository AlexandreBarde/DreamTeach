!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?t(exports,require("@fullcalendar/core")):"function"==typeof define&&define.amd?define(["exports","@fullcalendar/core"],t):t((e=e||self).FullCalendarDayGrid={},e.FullCalendar)}(this,function(e,D){"use strict";var n=function(e,t){return(n=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(e,t){e.__proto__=t}||function(e,t){for(var r in t)t.hasOwnProperty(r)&&(e[r]=t[r])})(e,t)};function i(e,t){function r(){this.constructor=e}n(e,t),e.prototype=null===t?Object.create(t):(r.prototype=t.prototype,new r)}var h=function(){return(h=Object.assign||function(e){for(var t,r=1,n=arguments.length;r<n;r++)for(var i in t=arguments[r])Object.prototype.hasOwnProperty.call(t,i)&&(e[i]=t[i]);return e}).apply(this,arguments)},t=function(d){function e(){return null!==d&&d.apply(this,arguments)||this}return i(e,d),e.prototype.buildRenderRange=function(e,t,r){var n,i=this.dateEnv,o=d.prototype.buildRenderRange.call(this,e,t,r),s=o.start,l=o.end;if(/^(year|month)$/.test(t)&&(s=i.startOfWeek(s),(n=i.startOfWeek(l)).valueOf()!==l.valueOf()&&(l=D.addWeeks(n,1))),this.options.monthMode&&this.options.fixedWeekCount){var a=Math.ceil(D.diffWeeks(s,l));l=D.addWeeks(l,6-a)}return{start:s,end:l}},e}(D.DateProfileGenerator),p=function(){function e(e){var t=this;this.isHidden=!0,this.margin=10,this.documentMousedown=function(e){t.el&&!t.el.contains(e.target)&&t.hide()},this.options=e}return e.prototype.show=function(){this.isHidden&&(this.el||this.render(),this.el.style.display="",this.position(),this.isHidden=!1,this.trigger("show"))},e.prototype.hide=function(){this.isHidden||(this.el.style.display="none",this.isHidden=!0,this.trigger("hide"))},e.prototype.render=function(){var t=this,e=this.options,r=this.el=D.createElement("div",{className:"fc-popover "+(e.className||""),style:{top:"0",left:"0"}});"function"==typeof e.content&&e.content(r),e.parentEl.appendChild(r),D.listenBySelector(r,"click",".fc-close",function(e){t.hide()}),e.autoHide&&document.addEventListener("mousedown",this.documentMousedown)},e.prototype.destroy=function(){this.hide(),this.el&&(D.removeElement(this.el),this.el=null),document.removeEventListener("mousedown",this.documentMousedown)},e.prototype.position=function(){var e,t,r=this.options,n=this.el,i=n.getBoundingClientRect(),o=D.computeRect(n.offsetParent),s=D.computeClippingRect(r.parentEl);e=r.top||0,t=void 0!==r.left?r.left:void 0!==r.right?r.right-i.width:0,e=Math.min(e,s.bottom-i.height-this.margin),e=Math.max(e,s.top+this.margin),t=Math.min(t,s.right-i.width-this.margin),t=Math.max(t,s.left+this.margin),D.applyStyle(n,{top:e-o.top,left:t-o.left})},e.prototype.trigger=function(e){this.options[e]&&this.options[e].apply(this,Array.prototype.slice.call(arguments,1))},e}(),r=function(e){function t(){return null!==e&&e.apply(this,arguments)||this}return i(t,e),t.prototype.renderSegHtml=function(e,t){var r,n,i=this.context.options,o=e.eventRange,s=o.def,l=o.ui,a=s.allDay,d=l.startEditable,c=a&&e.isStart&&l.durationEditable&&i.eventResizableFromStart,h=a&&e.isEnd&&l.durationEditable,p=this.getSegClasses(e,d,c||h,t),u=D.cssToStr(this.getSkinCss(l)),f="";return p.unshift("fc-day-grid-event","fc-h-event"),e.isStart&&(r=this.getTimeText(o))&&(f='<span class="fc-time">'+D.htmlEscape(r)+"</span>"),n='<span class="fc-title">'+(D.htmlEscape(s.title||"")||"&nbsp;")+"</span>",'<a class="'+p.join(" ")+'"'+(s.url?' href="'+D.htmlEscape(s.url)+'"':"")+(u?' style="'+u+'"':"")+'><div class="fc-content">'+("rtl"===i.dir?n+" "+f:f+" "+n)+"</div>"+(c?'<div class="fc-resizer fc-start-resizer"></div>':"")+(h?'<div class="fc-resizer fc-end-resizer"></div>':"")+"</a>"},t.prototype.computeEventTimeFormat=function(){return{hour:"numeric",minute:"2-digit",omitZeroMinute:!0,meridiem:"narrow"}},t.prototype.computeDisplayEventEnd=function(){return!1},t}(D.FgEventRenderer),a=function(r){function e(e){var t=r.call(this,e.context)||this;return t.dayGrid=e,t}return i(e,r),e.prototype.attachSegs=function(e,t){var r=this.rowStructs=this.renderSegRows(e);this.dayGrid.rowEls.forEach(function(e,t){e.querySelector(".fc-content-skeleton > table").appendChild(r[t].tbodyEl)}),t||this.dayGrid.removeSegPopover()},e.prototype.detachSegs=function(){for(var e,t=this.rowStructs||[];e=t.pop();)D.removeElement(e.tbodyEl);this.rowStructs=null},e.prototype.renderSegRows=function(e){var t,r,n=[];for(t=this.groupSegRows(e),r=0;r<t.length;r++)n.push(this.renderSegRow(r,t[r]));return n},e.prototype.renderSegRow=function(e,t){var r,n,i,o,s,l,a,d=this.dayGrid,c=d.colCnt,h=d.isRtl,p=this.buildSegLevels(t),u=Math.max(1,p.length),f=document.createElement("tbody"),g=[],m=[],y=[];function v(e){for(;i<e;)(a=(y[r-1]||[])[i])?a.rowSpan=(a.rowSpan||1)+1:(a=document.createElement("td"),o.appendChild(a)),m[r][i]=a,y[r][i]=a,i++}for(r=0;r<u;r++){if(n=p[r],i=0,o=document.createElement("tr"),g.push([]),m.push([]),y.push([]),n)for(s=0;s<n.length;s++){l=n[s];var b=h?c-1-l.lastCol:l.firstCol,w=h?c-1-l.firstCol:l.lastCol;for(v(b),a=D.createElement("td",{className:"fc-event-container"},l.el),b!==w?a.colSpan=w-b+1:y[r][i]=a;i<=w;)m[r][i]=a,g[r][i]=l,i++;o.appendChild(a)}v(c);var S=d.renderProps.renderIntroHtml();S&&(d.isRtl?D.appendToElement(o,S):D.prependToElement(o,S)),f.appendChild(o)}return{row:e,tbodyEl:f,cellMatrix:m,segMatrix:g,segLevels:p,segs:t}},e.prototype.buildSegLevels=function(e){var t,r,n,i=this.dayGrid,o=i.isRtl,s=i.colCnt,l=[];for(e=this.sortEventSegs(e),t=0;t<e.length;t++){for(r=e[t],n=0;n<l.length&&d(r,l[n]);n++);r.level=n,r.leftCol=o?s-1-r.lastCol:r.firstCol,r.rightCol=o?s-1-r.firstCol:r.lastCol,(l[n]||(l[n]=[])).push(r)}for(n=0;n<l.length;n++)l[n].sort(c);return l},e.prototype.groupSegRows=function(e){var t,r=[];for(t=0;t<this.dayGrid.rowCnt;t++)r.push([]);for(t=0;t<e.length;t++)r[e[t].row].push(e[t]);return r},e.prototype.computeDisplayEventEnd=function(){return 1===this.dayGrid.colCnt},e}(r);function d(e,t){var r,n;for(r=0;r<t.length;r++)if((n=t[r]).firstCol<=e.lastCol&&n.lastCol>=e.firstCol)return!0;return!1}function c(e,t){return e.leftCol-t.leftCol}var u=function(e){function t(){return null!==e&&e.apply(this,arguments)||this}return i(t,e),t.prototype.attachSegs=function(e,t){var o=t.sourceSeg,s=this.rowStructs=this.renderSegRows(e);this.dayGrid.rowEls.forEach(function(e,t){var r,n,i=D.htmlToElement('<div class="fc-mirror-skeleton"><table></table></div>');o&&o.row===t?r=o.el:(r=e.querySelector(".fc-content-skeleton tbody"))||(r=e.querySelector(".fc-content-skeleton table")),n=r.getBoundingClientRect().top-e.getBoundingClientRect().top,i.style.top=n+"px",i.querySelector("table").appendChild(s[t].tbodyEl),e.appendChild(i)})},t}(a),f=function(r){function e(e){var t=r.call(this,e.context)||this;return t.fillSegTag="td",t.dayGrid=e,t}return i(e,r),e.prototype.renderSegs=function(e,t){"bgEvent"===e&&(t=t.filter(function(e){return e.eventRange.def.allDay})),r.prototype.renderSegs.call(this,e,t)},e.prototype.attachSegs=function(e,t){var r,n,i,o=[];for(r=0;r<t.length;r++)n=t[r],i=this.renderFillRow(e,n),this.dayGrid.rowEls[n.row].appendChild(i),o.push(i);return o},e.prototype.renderFillRow=function(e,t){var r,n,i,o=this.dayGrid,s=o.colCnt,l=o.isRtl,a=l?s-1-t.lastCol:t.firstCol,d=(l?s-1-t.firstCol:t.lastCol)+1;r="businessHours"===e?"bgevent":e.toLowerCase(),i=(n=D.htmlToElement('<div class="fc-'+r+'-skeleton"><table><tr></tr></table></div>')).getElementsByTagName("tr")[0],0<a&&D.appendToElement(i,new Array(a+1).join("<td></td>")),t.el.colSpan=d-a,i.appendChild(t.el),d<s&&D.appendToElement(i,new Array(s-d+1).join("<td></td>"));var c=o.renderProps.renderIntroHtml();return c&&(o.isRtl?D.appendToElement(i,c):D.prependToElement(i,c)),n},e}(D.FillRenderer),g=function(o){function e(e,t){var r=o.call(this,e,t)||this,n=r.eventRenderer=new s(r),i=r.renderFrame=D.memoizeRendering(r._renderFrame);return r.renderFgEvents=D.memoizeRendering(n.renderSegs.bind(n),n.unrender.bind(n),[i]),r.renderEventSelection=D.memoizeRendering(n.selectByInstanceId.bind(n),n.unselectByInstanceId.bind(n),[r.renderFgEvents]),r.renderEventDrag=D.memoizeRendering(n.hideByHash.bind(n),n.showByHash.bind(n),[i]),r.renderEventResize=D.memoizeRendering(n.hideByHash.bind(n),n.showByHash.bind(n),[i]),e.calendar.registerInteractiveComponent(r,{el:r.el,useEventCenter:!1}),r}return i(e,o),e.prototype.render=function(e){this.renderFrame(e.date),this.renderFgEvents(e.fgSegs),this.renderEventSelection(e.eventSelection),this.renderEventDrag(e.eventDragInstances),this.renderEventResize(e.eventResizeInstances)},e.prototype.destroy=function(){o.prototype.destroy.call(this),this.renderFrame.unrender(),this.calendar.unregisterInteractiveComponent(this)},e.prototype._renderFrame=function(e){var t=this.theme,r=this.dateEnv.format(e,D.createFormatter(this.opt("dayPopoverFormat")));this.el.innerHTML='<div class="fc-header '+t.getClass("popoverHeader")+'"><span class="fc-title">'+D.htmlEscape(r)+'</span><span class="fc-close '+t.getIconClass("close")+'"></span></div><div class="fc-body '+t.getClass("popoverContent")+'"><div class="fc-event-container"></div></div>',this.segContainerEl=this.el.querySelector(".fc-event-container")},e.prototype.queryHit=function(e,t,r,n){var i=this.props.date;if(e<r&&t<n)return{component:this,dateSpan:{allDay:!0,range:{start:i,end:D.addDays(i,1)}},dayEl:this.el,rect:{left:0,top:0,right:r,bottom:n},layer:1}},e}(D.DateComponent),s=function(r){function e(e){var t=r.call(this,e.context)||this;return t.dayTile=e,t}return i(e,r),e.prototype.attachSegs=function(e){for(var t=0,r=e;t<r.length;t++){var n=r[t];this.dayTile.segContainerEl.appendChild(n.el)}},e.prototype.detachSegs=function(e){for(var t=0,r=e;t<r.length;t++){var n=r[t];D.removeElement(n.el)}},e}(r),o=function(){function e(e){this.context=e}return e.prototype.renderHtml=function(e){var t=[];e.renderIntroHtml&&t.push(e.renderIntroHtml());for(var r=0,n=e.cells;r<n.length;r++){var i=n[r];t.push(l(i.date,e.dateProfile,this.context,i.htmlAttrs))}return e.cells.length||t.push('<td class="fc-day '+this.context.theme.getClass("widgetContent")+'"></td>'),"rtl"===this.context.options.dir&&t.reverse(),"<tr>"+t.join("")+"</tr>"},e}();function l(e,t,r,n){var i=r.dateEnv,o=r.theme,s=D.rangeContainsMarker(t.activeRange,e),l=D.getDayClasses(e,t,r);return l.unshift("fc-day",o.getClass("widgetContent")),'<td class="'+l.join(" ")+'"'+(s?' data-date="'+i.formatIso(e,{omitTime:!0})+'"':"")+(n?" "+n:"")+"></td>"}var m=D.createFormatter({day:"numeric"}),y=D.createFormatter({week:"numeric"}),v=function(l){function e(e,t,r){var n=l.call(this,e,t)||this;n.bottomCoordPadding=0,n.isCellSizesDirty=!1;var i=n.eventRenderer=new a(n),o=n.fillRenderer=new f(n);n.mirrorRenderer=new u(n);var s=n.renderCells=D.memoizeRendering(n._renderCells,n._unrenderCells);return n.renderBusinessHours=D.memoizeRendering(o.renderSegs.bind(o,"businessHours"),o.unrender.bind(o,"businessHours"),[s]),n.renderDateSelection=D.memoizeRendering(o.renderSegs.bind(o,"highlight"),o.unrender.bind(o,"highlight"),[s]),n.renderBgEvents=D.memoizeRendering(o.renderSegs.bind(o,"bgEvent"),o.unrender.bind(o,"bgEvent"),[s]),n.renderFgEvents=D.memoizeRendering(i.renderSegs.bind(i),i.unrender.bind(i),[s]),n.renderEventSelection=D.memoizeRendering(i.selectByInstanceId.bind(i),i.unselectByInstanceId.bind(i),[n.renderFgEvents]),n.renderEventDrag=D.memoizeRendering(n._renderEventDrag,n._unrenderEventDrag,[s]),n.renderEventResize=D.memoizeRendering(n._renderEventResize,n._unrenderEventResize,[s]),n.renderProps=r,n}return i(e,l),e.prototype.render=function(e){var t=e.cells;this.rowCnt=t.length,this.colCnt=t[0].length,this.renderCells(t,e.isRigid),this.renderBusinessHours(e.businessHourSegs),this.renderDateSelection(e.dateSelectionSegs),this.renderBgEvents(e.bgEventSegs),this.renderFgEvents(e.fgEventSegs),this.renderEventSelection(e.eventSelection),this.renderEventDrag(e.eventDrag),this.renderEventResize(e.eventResize),this.segPopoverTile&&this.updateSegPopoverTile()},e.prototype.destroy=function(){l.prototype.destroy.call(this),this.renderCells.unrender()},e.prototype.getCellRange=function(e,t){var r=this.props.cells[e][t].date;return{start:r,end:D.addDays(r,1)}},e.prototype.updateSegPopoverTile=function(e,t){var r=this.props;this.segPopoverTile.receiveProps({date:e||this.segPopoverTile.props.date,fgSegs:t||this.segPopoverTile.props.fgSegs,eventSelection:r.eventSelection,eventDragInstances:r.eventDrag?r.eventDrag.affectedInstances:null,eventResizeInstances:r.eventResize?r.eventResize.affectedInstances:null})},e.prototype._renderCells=function(e,t){var r,n,i=this.view,o=this.dateEnv,s=this.rowCnt,l=this.colCnt,a="";for(r=0;r<s;r++)a+=this.renderDayRowHtml(r,t);for(this.el.innerHTML=a,this.rowEls=D.findElements(this.el,".fc-row"),this.cellEls=D.findElements(this.el,".fc-day, .fc-disabled-day"),this.isRtl&&this.cellEls.reverse(),this.rowPositions=new D.PositionCache(this.el,this.rowEls,!1,!0),this.colPositions=new D.PositionCache(this.el,this.cellEls.slice(0,l),!0,!1),r=0;r<s;r++)for(n=0;n<l;n++)this.publiclyTrigger("dayRender",[{date:o.toDate(e[r][n].date),el:this.getCellEl(r,n),view:i}]);this.isCellSizesDirty=!0},e.prototype._unrenderCells=function(){this.removeSegPopover()},e.prototype.renderDayRowHtml=function(e,t){var r=this.theme,n=["fc-row","fc-week",r.getClass("dayRow")];t&&n.push("fc-rigid");var i=new o(this.context);return'<div class="'+n.join(" ")+'"><div class="fc-bg"><table class="'+r.getClass("tableGrid")+'">'+i.renderHtml({cells:this.props.cells[e],dateProfile:this.props.dateProfile,renderIntroHtml:this.renderProps.renderBgIntroHtml})+'</table></div><div class="fc-content-skeleton"><table>'+(this.getIsNumbersVisible()?"<thead>"+this.renderNumberTrHtml(e)+"</thead>":"")+"</table></div></div>"},e.prototype.getIsNumbersVisible=function(){return this.getIsDayNumbersVisible()||this.renderProps.cellWeekNumbersVisible||this.renderProps.colWeekNumbersVisible},e.prototype.getIsDayNumbersVisible=function(){return 1<this.rowCnt},e.prototype.renderNumberTrHtml=function(e){var t=this.renderProps.renderNumberIntroHtml(e,this);return"<tr>"+(this.isRtl?"":t)+this.renderNumberCellsHtml(e)+(this.isRtl?t:"")+"</tr>"},e.prototype.renderNumberCellsHtml=function(e){var t,r,n=[];for(t=0;t<this.colCnt;t++)r=this.props.cells[e][t].date,n.push(this.renderNumberCellHtml(r));return this.isRtl&&n.reverse(),n.join("")},e.prototype.renderNumberCellHtml=function(e){var t,r,n=this.view,i=this.dateEnv,o="",s=D.rangeContainsMarker(this.props.dateProfile.activeRange,e),l=this.getIsDayNumbersVisible()&&s;return l||this.renderProps.cellWeekNumbersVisible?((t=D.getDayClasses(e,this.props.dateProfile,this.context)).unshift("fc-day-top"),this.renderProps.cellWeekNumbersVisible&&(r=i.weekDow),o+='<td class="'+t.join(" ")+'"'+(s?' data-date="'+i.formatIso(e,{omitTime:!0})+'"':"")+">",this.renderProps.cellWeekNumbersVisible&&e.getUTCDay()===r&&(o+=D.buildGotoAnchorHtml(n,{date:e,type:"week"},{class:"fc-week-number"},i.format(e,y))),l&&(o+=D.buildGotoAnchorHtml(n,e,{class:"fc-day-number"},i.format(e,m))),o+="</td>"):"<td></td>"},e.prototype.updateSize=function(e){var t=this.fillRenderer,r=this.eventRenderer,n=this.mirrorRenderer;(e||this.isCellSizesDirty)&&(this.buildColPositions(),this.buildRowPositions(),this.isCellSizesDirty=!1),t.computeSizes(e),r.computeSizes(e),n.computeSizes(e),t.assignSizes(e),r.assignSizes(e),n.assignSizes(e)},e.prototype.buildColPositions=function(){this.colPositions.build()},e.prototype.buildRowPositions=function(){this.rowPositions.build(),this.rowPositions.bottoms[this.rowCnt-1]+=this.bottomCoordPadding},e.prototype.positionToHit=function(e,t){var r=this.colPositions,n=this.rowPositions,i=r.leftToIndex(e),o=n.topToIndex(t);if(null!=o&&null!=i)return{row:o,col:i,dateSpan:{range:this.getCellRange(o,i),allDay:!0},dayEl:this.getCellEl(o,i),relativeRect:{left:r.lefts[i],right:r.rights[i],top:n.tops[o],bottom:n.bottoms[o]}}},e.prototype.getCellEl=function(e,t){return this.cellEls[e*this.colCnt+t]},e.prototype._renderEventDrag=function(e){e&&(this.eventRenderer.hideByHash(e.affectedInstances),this.fillRenderer.renderSegs("highlight",e.segs))},e.prototype._unrenderEventDrag=function(e){e&&(this.eventRenderer.showByHash(e.affectedInstances),this.fillRenderer.unrender("highlight"))},e.prototype._renderEventResize=function(e){e&&(this.eventRenderer.hideByHash(e.affectedInstances),this.fillRenderer.renderSegs("highlight",e.segs),this.mirrorRenderer.renderSegs(e.segs,{isResizing:!0,sourceSeg:e.sourceSeg}))},e.prototype._unrenderEventResize=function(e){e&&(this.eventRenderer.showByHash(e.affectedInstances),this.fillRenderer.unrender("highlight"),this.mirrorRenderer.unrender(e.segs,{isResizing:!0,sourceSeg:e.sourceSeg}))},e.prototype.removeSegPopover=function(){this.segPopover&&this.segPopover.hide()},e.prototype.limitRows=function(e){var t,r,n=this.eventRenderer.rowStructs||[];for(t=0;t<n.length;t++)this.unlimitRow(t),!1!==(r=!!e&&("number"==typeof e?e:this.computeRowLevelLimit(t)))&&this.limitRow(t,r)},e.prototype.computeRowLevelLimit=function(e){var t,r,n=this.rowEls[e].getBoundingClientRect().bottom,i=D.findChildren(this.eventRenderer.rowStructs[e].tbodyEl);for(t=0;t<i.length;t++)if((r=i[t]).classList.remove("fc-limited"),r.getBoundingClientRect().bottom>n)return t;return!1},e.prototype.limitRow=function(t,r){var e,n,i,o,s,l,a,d,c,h,p,u,f,g,m,y=this,v=this.colCnt,b=this.isRtl,w=this.eventRenderer.rowStructs[t],S=[],C=0,E=function(e){for(;C<e;)(l=y.getCellSegs(t,C,r)).length&&(c=n[r-1][C],m=y.renderMoreLink(t,C,l),g=D.createElement("div",null,m),c.appendChild(g),S.push(g[0])),C++};if(r&&r<w.segLevels.length){for(e=w.segLevels[r-1],n=w.cellMatrix,(i=D.findChildren(w.tbodyEl).slice(r)).forEach(function(e){e.classList.add("fc-limited")}),o=0;o<e.length;o++){s=e[o];var R=b?v-1-s.lastCol:s.firstCol,H=b?v-1-s.firstCol:s.lastCol;for(E(R),d=[],a=0;C<=H;)l=this.getCellSegs(t,C,r),d.push(l),a+=l.length,C++;if(a){for(h=(c=n[r-1][R]).rowSpan||1,p=[],u=0;u<d.length;u++)f=D.createElement("td",{className:"fc-more-cell",rowSpan:h}),l=d[u],m=this.renderMoreLink(t,R+u,[s].concat(l)),g=D.createElement("div",null,m),f.appendChild(g),p.push(f),S.push(f);c.classList.add("fc-limited"),D.insertAfterElement(c,p),i.push(c)}}E(this.colCnt),w.moreEls=S,w.limitedEls=i}},e.prototype.unlimitRow=function(e){var t=this.eventRenderer.rowStructs[e];t.moreEls&&(t.moreEls.forEach(D.removeElement),t.moreEls=null),t.limitedEls&&(t.limitedEls.forEach(function(e){e.classList.remove("fc-limited")}),t.limitedEls=null)},e.prototype.renderMoreLink=function(d,c,h){var p=this,u=this.view,f=this.dateEnv,e=D.createElement("a",{className:"fc-more"});return e.innerText=this.getMoreLinkText(h.length),e.addEventListener("click",function(e){var t=p.opt("eventLimitClick"),r=p.isRtl?p.colCnt-c-1:c,n=p.props.cells[d][r].date,i=e.currentTarget,o=p.getCellEl(d,c),s=p.getCellSegs(d,c),l=p.resliceDaySegs(s,n),a=p.resliceDaySegs(h,n);"function"==typeof t&&(t=p.publiclyTrigger("eventLimitClick",[{date:f.toDate(n),allDay:!0,dayEl:o,moreEl:i,segs:l,hiddenSegs:a,jsEvent:e,view:u}])),"popover"===t?p.showSegPopover(d,c,i,l):"string"==typeof t&&u.calendar.zoomTo(n,t)}),e},e.prototype.showSegPopover=function(t,e,r,n){var i,o,s=this,l=this.calendar,a=this.view,d=this.theme,c=this.isRtl?this.colCnt-e-1:e,h=r.parentNode;i=1===this.rowCnt?a.el:this.rowEls[t],o={className:"fc-more-popover "+d.getClass("popover"),parentEl:a.el,top:D.computeRect(i).top,autoHide:!0,content:function(e){s.segPopoverTile=new g(s.context,e),s.updateSegPopoverTile(s.props.cells[t][c].date,n)},hide:function(){s.segPopoverTile.destroy(),s.segPopoverTile=null,s.segPopover.destroy(),s.segPopover=null}},this.isRtl?o.right=D.computeRect(h).right+1:o.left=D.computeRect(h).left-1,this.segPopover=new p(o),this.segPopover.show(),l.releaseAfterSizingTriggers()},e.prototype.resliceDaySegs=function(e,t){for(var r=t,n={start:r,end:D.addDays(r,1)},i=[],o=0,s=e;o<s.length;o++){var l=s[o],a=l.eventRange,d=a.range,c=D.intersectRanges(d,n);c&&i.push(h({},l,{eventRange:{def:a.def,ui:h({},a.ui,{durationEditable:!1}),instance:a.instance,range:c},isStart:l.isStart&&c.start.valueOf()===d.start.valueOf(),isEnd:l.isEnd&&c.end.valueOf()===d.end.valueOf()}))}return i},e.prototype.getMoreLinkText=function(e){var t=this.opt("eventLimitText");return"function"==typeof t?t(e):"+"+e+" "+t},e.prototype.getCellSegs=function(e,t,r){for(var n,i=this.eventRenderer.rowStructs[e].segMatrix,o=r||0,s=[];o<i.length;)(n=i[o][t])&&s.push(n),o++;return s},e}(D.DateComponent),b=D.createFormatter({week:"numeric"}),w=function(a){function e(e,t,r,n){var i=a.call(this,e,t,r,n)||this;i.renderHeadIntroHtml=function(){var e=i.theme;return i.colWeekNumbersVisible?'<th class="fc-week-number '+e.getClass("widgetHeader")+'" '+i.weekNumberStyleAttr()+"><span>"+D.htmlEscape(i.opt("weekLabel"))+"</span></th>":""},i.renderDayGridNumberIntroHtml=function(e,t){var r=i.dateEnv,n=t.props.cells[e][0].date;return i.colWeekNumbersVisible?'<td class="fc-week-number" '+i.weekNumberStyleAttr()+">"+D.buildGotoAnchorHtml(i,{date:n,type:"week",forceOff:1===t.colCnt},r.format(n,b))+"</td>":""},i.renderDayGridBgIntroHtml=function(){var e=i.theme;return i.colWeekNumbersVisible?'<td class="fc-week-number '+e.getClass("widgetContent")+'" '+i.weekNumberStyleAttr()+"></td>":""},i.renderDayGridIntroHtml=function(){return i.colWeekNumbersVisible?'<td class="fc-week-number" '+i.weekNumberStyleAttr()+"></td>":""},i.el.classList.add("fc-dayGrid-view"),i.el.innerHTML=i.renderSkeletonHtml(),i.scroller=new D.ScrollComponent("hidden","auto");var o=i.scroller.el;i.el.querySelector(".fc-body > tr > td").appendChild(o),o.classList.add("fc-day-grid-container");var s,l=D.createElement("div",{className:"fc-day-grid"});return o.appendChild(l),i.opt("weekNumbers")?i.opt("weekNumbersWithinDays")?(s=!0,i.colWeekNumbersVisible=!1):(s=!1,i.colWeekNumbersVisible=!0):s=i.colWeekNumbersVisible=!1,i.dayGrid=new v(i.context,l,{renderNumberIntroHtml:i.renderDayGridNumberIntroHtml,renderBgIntroHtml:i.renderDayGridBgIntroHtml,renderIntroHtml:i.renderDayGridIntroHtml,colWeekNumbersVisible:i.colWeekNumbersVisible,cellWeekNumbersVisible:s}),i}return i(e,a),e.prototype.destroy=function(){a.prototype.destroy.call(this),this.dayGrid.destroy(),this.scroller.destroy()},e.prototype.renderSkeletonHtml=function(){var e=this.theme;return'<table class="'+e.getClass("tableGrid")+'">'+(this.opt("columnHeader")?'<thead class="fc-head"><tr><td class="fc-head-container '+e.getClass("widgetHeader")+'">&nbsp;</td></tr></thead>':"")+'<tbody class="fc-body"><tr><td class="'+e.getClass("widgetContent")+'"></td></tr></tbody></table>'},e.prototype.weekNumberStyleAttr=function(){return null!=this.weekNumberWidth?'style="width:'+this.weekNumberWidth+'px"':""},e.prototype.hasRigidRows=function(){var e=this.opt("eventLimit");return e&&"number"!=typeof e},e.prototype.updateSize=function(e,t,r){a.prototype.updateSize.call(this,e,t,r),this.dayGrid.updateSize(e)},e.prototype.updateBaseSize=function(e,t,r){var n,i,o=this.dayGrid,s=this.opt("eventLimit"),l=this.header?this.header.el:null;o.rowEls?(this.colWeekNumbersVisible&&(this.weekNumberWidth=D.matchCellWidths(D.findElements(this.el,".fc-week-number"))),this.scroller.clear(),l&&D.uncompensateScroll(l),o.removeSegPopover(),s&&"number"==typeof s&&o.limitRows(s),n=this.computeScrollerHeight(t),this.setGridHeight(n,r),s&&"number"!=typeof s&&o.limitRows(s),r||(this.scroller.setHeight(n),((i=this.scroller.getScrollbarWidths()).left||i.right)&&(l&&D.compensateScroll(l,i),n=this.computeScrollerHeight(t),this.scroller.setHeight(n)),this.scroller.lockOverflow(i))):r||(n=this.computeScrollerHeight(t),this.scroller.setHeight(n))},e.prototype.computeScrollerHeight=function(e){return e-D.subtractInnerElHeight(this.el,this.scroller.el)},e.prototype.setGridHeight=function(e,t){this.opt("monthMode")?(t&&(e*=this.dayGrid.rowCnt/6),D.distributeHeight(this.dayGrid.rowEls,e,!t)):t?D.undistributeHeight(this.dayGrid.rowEls):D.distributeHeight(this.dayGrid.rowEls,e,!0)},e.prototype.computeInitialDateScroll=function(){return{top:0}},e.prototype.queryDateScroll=function(){return{top:this.scroller.getScrollTop()}},e.prototype.applyDateScroll=function(e){void 0!==e.top&&this.scroller.setScrollTop(e.top)},e}(D.View);w.prototype.dateProfileGeneratorClass=t;var S=function(n){function e(e,t){var r=n.call(this,e,t.el)||this;return r.slicer=new C,r.dayGrid=t,e.calendar.registerInteractiveComponent(r,{el:r.dayGrid.el}),r}return i(e,n),e.prototype.destroy=function(){n.prototype.destroy.call(this),this.calendar.unregisterInteractiveComponent(this)},e.prototype.render=function(e){var t=this.dayGrid,r=e.dateProfile,n=e.dayTable;t.receiveProps(h({},this.slicer.sliceProps(e,r,e.nextDayThreshold,t,n),{dateProfile:r,cells:n.cells,isRigid:e.isRigid}))},e.prototype.queryHit=function(e,t){var r=this.dayGrid.positionToHit(e,t);if(r)return{component:this.dayGrid,dateSpan:r.dateSpan,dayEl:r.dayEl,rect:{left:r.relativeRect.left,right:r.relativeRect.right,top:r.relativeRect.top,bottom:r.relativeRect.bottom},layer:0}},e}(D.DateComponent),C=function(e){function t(){return null!==e&&e.apply(this,arguments)||this}return i(t,e),t.prototype.sliceRange=function(e,t){return t.sliceRange(e)},t}(D.Slicer),E=function(o){function e(e,t,r,n){var i=o.call(this,e,t,r,n)||this;return i.buildDayTable=D.memoize(R),i.opt("columnHeader")&&(i.header=new D.DayHeader(i.context,i.el.querySelector(".fc-head-container"))),i.simpleDayGrid=new S(i.context,i.dayGrid),i}return i(e,o),e.prototype.destroy=function(){o.prototype.destroy.call(this),this.header&&this.header.destroy(),this.simpleDayGrid.destroy()},e.prototype.render=function(e){o.prototype.render.call(this,e);var t=this.props.dateProfile,r=this.dayTable=this.buildDayTable(t,this.dateProfileGenerator);this.header&&this.header.receiveProps({dateProfile:t,dates:r.headerDates,datesRepDistinctDays:1===r.rowCnt,renderIntroHtml:this.renderHeadIntroHtml}),this.simpleDayGrid.receiveProps({dateProfile:t,dayTable:r,businessHours:e.businessHours,dateSelection:e.dateSelection,eventStore:e.eventStore,eventUiBases:e.eventUiBases,eventSelection:e.eventSelection,eventDrag:e.eventDrag,eventResize:e.eventResize,isRigid:this.hasRigidRows(),nextDayThreshold:this.nextDayThreshold})},e}(w);function R(e,t){var r=new D.DaySeries(e.renderRange,t);return new D.DayTable(r,/year|month|week/.test(e.currentRangeUnit))}var H=D.createPlugin({defaultView:"dayGridMonth",views:{dayGrid:E,dayGridDay:{type:"dayGrid",duration:{days:1}},dayGridWeek:{type:"dayGrid",duration:{weeks:1}},dayGridMonth:{type:"dayGrid",duration:{months:1},monthMode:!0,fixedWeekCount:!0}}});e.AbstractDayGridView=w,e.DayBgRow=o,e.DayGrid=v,e.DayGridSlicer=C,e.DayGridView=E,e.SimpleDayGrid=S,e.buildBasicDayTable=R,e.default=H,Object.defineProperty(e,"__esModule",{value:!0})});