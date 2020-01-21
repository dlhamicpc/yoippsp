import moment from 'moment';

export default function stringHelpers() {

   Vue.filter('firstLetterToUpper', function(text){
        if(text != null){
            return text.charAt(0).toUpperCase() + text.slice(1);
        }
        else{
            return 'Empty';
        }
    }); 

    
    Vue.filter('ucwords', function(text){ 

        if(text != null){

            text = text.trim();
            
            let words = text.split(" ");
            let result = '';
            for( let index in words ) {
                let word = words[ index ];
                result += (word[0].toUpperCase() + word.slice(1) + ' ');
            } 
            
            return result.trim();
            
        }
        else{
            return 'Empty';
        }
            
    });

    Vue.filter('only_day', function(timestamp){
        
        if(timestamp != null){
            let timestamps = timestamp.split(" ");
            return timestamps[0].split("-")[2];
        }
        else{
            return 'Empty';
        }
    });

    Vue.filter('only_month', function(timestamp){
        
        if(timestamp != null){
            let timestamps = timestamp.split(" ");
            let month = Number( timestamps[0].split("-")[1] );

            let monthes = ['', 'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 
                          'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                
            return monthes[ month ];
        }
        else{
            return 'Empty';
        }
    });

    Vue.filter('only_time', function(timestamp){
        
        if(timestamp != null){
            let timestamps = timestamp.split(" ");
            let times = timestamps[1].split(":");
            return times[0] + ':' + times[1] ;
        }
        else{
            return 'Empty';
        }
    });

    Vue.filter('filterDateFormat', function(rawDate){
        let date = rawDate.split(" ")[0];
        // 12/21/2001 format "mm/dd/yyyy" *from* "yyyy-mm-dd"
        let date_array = rawDate.split("-");
        
        return date_array[1] + "/" + date_array[2] + "/" + date_array[0];
    });

    Vue.filter('date_format_DDMMYY', function(rawDate){
        return moment(rawDate).format('DD MMM YYYY, H:mm a');
    });

    Vue.filter('birth_day', function(rawDate){
        return moment(rawDate).format('DD-MM-YYYY');
    });

    Vue.filter('from_now', function(rawDate){
        //return moment(rawDate).format('MMMM Do YYYY, H:mm:s');
        return moment(rawDate,'YYYYMMDD').fromNow();
    });

    Vue.filter('money', function(rawMoney){

        try {
            if (rawMoney == null ){
                return "0 Birr";
            }
            else if( rawMoney.trim() == "" ){
                return "0 Birr";
            }
            else if( /[^0-9.,]/.test( rawMoney )){
                return "0 Birr";
            }
        } catch (error) {
            if( /[^0-9.,]/.test( rawMoney )){
                return "0 Birr";
            }
        }
        
        return rawMoney + " Birr";
    });
   
    
}
