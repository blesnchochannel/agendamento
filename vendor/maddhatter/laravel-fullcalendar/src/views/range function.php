'eventRender' => 'function(event, element, view){
                			return (event.ranges.filter(function(range){
                				return (event.start.isBefore(range.end) &&
                				event.end.isAfter(range.start));
                			}).length)>0;
                		}',