<?php function wp_keword_tool_fn(){ ?>
 

 <?php 
if(isset($_POST['wp_keyword_tool_google'])){
	foreach($_POST as $key => $val){
		
		if(stristr($key,'keyword'))
		update_option($key, $val);
	}
	
	echo '<div class="updated " id="message"><p>Changes saved</p></div>';
	
}

 $allletters = array();
 $en = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
 $allletters['English'] = $en;
 //French
 $allletters['French']= array( "é",  "è",  "ç", "à", "a", "z", "e", "r", "t", "y", "u", "i", "o", "p",  "$",  "q", "s", "d", "f", "g", "h", "j", "k", "l", "m", "ù",  "w", "x", "c", "v", "b", "n");
 
 //dutch
 $allletters['Dutch'] = array_merge( $en , array("ë","ÿ","ü","ï","ö","ä"));
 
 //German
 $allletters['German']= array("ß", "q", "w", "e", "r", "t", "z", "u", "i", "o", "p", "ü",  "a", "s", "d", "f", "g", "h", "j", "k", "l", "ö", "ä",  "y", "x", "c", "v", "b", "n", "m") ;
 
 $allletters['Russian']= array("ё" , "й" , "ц" , "у" , "к" , "е" , "н" , "г" , "ш" , "щ" , "з" , "х" , "ъ" , "ф" , "ы" , "в" , "а" , "п" , "р" , "о" , "л" , "д" , "ж" , "э" , "я" , "ч" , "с" , "м" , "и" , "т" , "ь" , "б" , "ю" , "!" , "№") ;
 
 $allletters['Spanish']= array("º" , "¡" , "q" , "w" , "e" , "r" , "t" , "y" , "u" , "i" , "o" , "p" , "ç" , "a" , "s" , "d" , "f" , "g" , "h" , "j" , "k" , "l" , "ñ" , "z" , "x" , "c" , "v" , "b" , "n" , "m");
 
 $allletters['Swedish']=  array("§" , "q" , "w" , "e" , "r" , "t" , "y" , "u" , "i" , "o" , "p" , "å" , "a" , "s" , "d" , "f" , "g" , "h" , "j" , "k" , "l" , "ö" , "ä" , "z" , "x" , "c" , "v" , "b" , "n" , "m" , "ë" , "ÿ" , "ü" , "ï") ;
 //arabic
 $allletters['Arabic'] = array("ذ", "ض", "ص", "ث", "ق", "ف", "غ", "ع", "ه", "خ", "ح", "ج", "د", "ش", "س", "ي", "ب", "ل", "ا", "ت", "ن", "م", "ك", "ط", "ئ", "ء", "ؤ", "ر", "لا", "ى", "ة", "و", "ز", "ظ");
 
 //albnian
 $allletters['Albanian'] = array_merge( $en , array('ç','ë') );
 
 //amharic
 $allletters['Amharic'] = array("፩", "ሀ", "በ", "ነ", "መ", "ወ", "ጠ", "ተ", "ለ", "ረ", "የ" , "ኣ", "ኡ", "አ", "እ", "ኤ", "ኧ", "እ", "አ", "ኦ", "ኢ",  "ቐ", "ቀ", "ከ", "ደ", "ኸ", "ገ", "ሰ", "ቸ", "ዘ", "ፈ");
 
 //armanian
 $allletters['Armanian']  =array( "ձ", "յ", "օ", "ռ", "ժ", "խ", "վ", "է", "ր", "դ", "ե", "ը", "ի", "ո", "բ", "չ", "ջ", "'", "ա", "ս", "տ", "ֆ", "կ", "հ", "ճ", "ք", "լ", "թ", "փ", "'", "զ", "ց", "գ", "ւ", "պ", "ն", "մ", "շ", "ղ", "ծ");
 
 //bangla
 $allletters['bangla']=array( "ৃ", "ৌ", "ৈ", "া", "ী", "ূ", "ব", "হ", "গ", "দ", "জ", "ড", "়", "ো", "ে", "্", "ি", "ু", "প", "র", "ক", "ত", "চ", "ট",  "ম", "ন", "ব", "ল", "স",  "য");
 
 //chineese
 $allletters['Chinese']=array( "手", "田", "水", "口", "廿", "卜", "山", "戈", "人", "心",  "日", "尸", "木", "火", "土", "竹", "十", "大", "中", "Ｚ", "難", "金", "女", "月", "弓");
 
 //coptic
 $allletters['Coptic']=array( "⸗", "ⲑ", "ⲱ", "ⲉ", "ⲣ", "ⲧ", "ⲯ", "ⲩ", "ⲓ", "ⲟ", "ⲡ",  "̀", "ⲁ", "ⲥ", "ⲇ", "ⲫ", "ⲅ", "ⲏ", "ϫ", "ⲕ", "ⲗ",  "̀", "ⲍ", "ⲝ", "ⲭ", "ϣ", "ⲃ", "ⲛ", "ⲙ", "́");
 
 //Croatian
 $allletters['Croatian'] = array("q", "w", "e", "r", "t", "z", "u", "i", "o", "p", "š", "đ", "ž", "a", "s", "d", "f", "g", "h", "j", "k", "l", "č", "ć",  "y", "x", "c", "v", "b", "n", "m")  ;
 
 //Czech
 $allletters['Czech'] =  array(  "ě", "š", "č", "ř", "ž", "ý", "á", "í", "é" , "q", "w", "e", "r", "t", "z", "u", "i", "o", "p", "ú",   "¨", "a", "s", "d", "f", "g", "h", "j", "k", "l", "ů", "§" , "y", "x", "c", "v", "b", "n", "m"  );
 
 //Danish
 $allletters['Danish'] =array( "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "å", "a", "s", "d", "f", "g", "h", "j", "k", "l", "æ", "ø",  "z", "x", "c", "v", "b", "n", "m" ,  "ë",   "ÿ", "ü", "ï", "ö", "ä") ;
 
 //Dhivehi
 $allletters['Dhivehi'] = array("ް", "އ", "ެ", "ރ", "ތ", "ޔ", "ު", "ި", "ޮ", "ޕ",  "ަ", "ސ", "ދ", "ފ", "ގ", "ހ", "ޖ", "ކ", "ލ",  "ޒ", "×", "ޗ", "ވ", "ބ", "ނ", "މ") ;
 
 
 //Estonian
 $allletters['Estonian']= array("ˇ", "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "ü", "õ", "a", "s", "d", "f", "g", "h", "j", "k", "l", "ö", "ä", "z", "x", "c", "v", "b", "n", "m");
 
 //Farsi
 $allletters['Farsi'] = array("۴", "۵", "۶", "ض", "ص", "ث", "ق", "ف", "غ", "ع", "ه", "خ", "ح", "ج", "چ", "ش", "س", "ی", "ب", "ل", "ا", "ت", "ن", "م", "ک", "گ", "ظ", "ط", "ز", "ر", "ذ", "د", "پ", "و");
 
 //Finnish
 $allletters['Finnish'] = array("§","q","w","e","r","t","y","u","i","o","p","å","a","s","d","f","g","h","j","k","l","ö","ä","z","x","c","v","b","n","m","ë","ÿ","ü","ï","ö","ä");
 
 
 //Georgian
 $allletters['Georgian']= array("№", "§",  "ღ", "ჯ", "უ", "კ", "ე", "ნ", "გ", "შ", "წ", "ზ", "ხ", "ც", "ფ", "ძ", "ვ", "თ", "ა", "პ", "რ", "ო", "ლ", "დ", "ჟ", "(", "ჭ", "ჩ", "ყ", "ს", "მ", "ი", "ტ", "ქ", "ბ", "ჰ") ;
 
 //Greek
 $allletters['Greek']=array("ς", "ε", "ρ", "τ", "υ", "θ", "ι", "ο", "π", "α", "σ", "δ", "φ", "γ", "η", "ξ", "κ", "λ", "ζ", "χ", "ψ", "ω", "β", "ν", "μ") ;
 
 
 //Gujarati
 $allletters['Gujarati']= array( "ૃ", "ૌ", "ૈ", "ા", "ી", "ૂ", "બ", "હ", "ગ", "દ", "જ", "ડ", "઼", "ૉ", "ો", "ે", "્", "િ", "ુ", "પ", "ર", "ક", "ત", "ચ", "ટ",  "ં", "મ", "ન", "વ", "લ", "સ", "ય");
 
 //Hindi
 $allletters['Hindi']= array( "ृ", "ौ", "ै", "ा", "ी", "ू", "ब", "ह", "ग", "द", "ज", "ड", "़", "ॉ", "ो", "े", "्", "ि", "ु", "प", "र", "क", "त", "च", "ट", "ॉ", "ं", "म", "न", "व", "ल", "स", "य") ;
 
 //Hungarian
 $allletters['Hungarian']= array("ö", "ü", "ó", "q", "w", "e", "r", "t", "z", "u", "i", "o", "p", "ő", "ú", "ű", "a", "s", "d", "f", "g", "h", "j", "k", "l", "é", "á", "ű", "y", "x", "c", "v", "b", "n", "m") ;
 
 //Irish
 $allletters['Irish']= $en;
 
 //Italian
 $allletters['Italian']= array( "ì", "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "è", "ù", "a", "s", "d", "f", "g", "h", "j", "k", "l", "ò", "à", "z", "x", "c", "v", "b", "n", "m");
 
 //Japanese
 $allletters['Japanese']= array("ろ", "ぬ", "ふ", "あ", "う", "え", "お", "や", "ゆ", "よ", "わ", "ほ", "へ", "た", "て", "い", "す", "か", "ん", "な", "に", "ら", "せ", "゛", "゜", "む", "ち", "と", "し", "は", "き", "く", "ま", "の", "り", "れ", "け", "む", "つ", "さ", "そ", "ひ", "こ", "み", "も", "ね", "る", "め");
 
 //Kannada
 $allletters['Kannada']= array("ೊ", "ೃ", "ೌ", "ೈ", "ಾ", "ೀ", "ೂ", "ಬ", "ಹ", "ಗ", "ದ", "ಜ", "ಡ",  "ೋ", "ೇ", "್", "ಿ", "ು", "ಪ", "ರ", "ಕ", "ತ", "ಚ", "ಟ", "ೆ", "ಂ", "ಮ", "ನ", "ವ", "ಲ", "ಸ", ",", ".", "ಯ", "ಒ", "ಃ", "ಋ", "ಔ", "ಐ", "ಆ", "ಈ", "ಊ", "ಭ", "ಙ", "ಘ", "ಧ", "ಝ", "ಢ", "ಞ", "ಓ", "ಏ", "ಅ", "ಇ", "ಉ", "ಫ", "ಱ", "ಖ", "ಥ", "ಛ", "ಠ", "ಎ", "ಣ", "ಳ", "ಶ", "ಷ");
 
 //Kazakh
 $allletters['Kazakh']= array("ә","і","ң","ғ",",",".","ү","ұ","қ","ө","һ","й","ц","у","к","е","н","г","ш","щ","з","х","ъ","ф","ы","в","а","п","р","о","л","д","ж","э","я","ч","с","м","и","т","ь","б","ю","№","!","Ә","І","Ң","Ғ","Ү","Ұ","Қ","Ө","Һ","Й","Ц","У","К","Е","Н","Г","Ш","Щ","З","Х","Ъ","Ф","Ы","В","А","П","Р","О","Л","Д","Ж","Э","Я","Ч","С","М","И","Т","Ь","Б","Ю") ;
 
 //Khmer
 $allletters['Khmer']= array("១","២","៣","៤","៥","៦","៧","៨","៩","០","គ","ធ","ឆ","ឹ","េ","រ","ត","យ","ុ","ិ","ោ","ផ","ៀ","ឨ","ឮ","ា","ស","ដ","ថ","ង","ហ","្","ក","ល","ើ","់","ឋ","ខ","ច","វ","ប","ន","ម","ំុ","។","៊​","៛","%","៌","័","៏","៝","ឪ","ឈ","ឺ","ែ","ឬ","ទ","ួ","ូ","ី","ៅ","ភ","ឿ","ឧ","ឭ","ាំ","ៃ","ឌ","ឣ","ះ","ញ","ឡ","ោៈ","៉","ឍ","ឃ","ជ","េះ","ព","ណ","ំ","ុះ","៕") ;
 
 //Khowar
 $allletters['Khowar']= array("ﺃ","۴","۵","۶","ق","و","ع","ر","ت","ے","ء","ی","ہ","پ","ئ","نگ","س","د","ف","گ","ح","ج","ک","ل","ز","ش","چ","ط","ب","ن","م","څ","ځ","ݲ","ڵ","ڑ","ٹ","ڇ","ڗ","ټ","ڂ","ڼ","ڠ","مﬞ","|","آ","ص","ڈ","ݯ","غ","ھ","ض","خ","ٷ",":","ذ","ژ","ث","ظ","ݱ","ڨ","ݰ","٫");
 
 //Korean
 $allletters['Korean']= array("ㅂ","ㅈ","ㄷ","ㄱ","ㅅ","ㅛ","ㅕ","ㅑ","ㅐ","ㅔ","ㅁ","ㄴ","ㅇ","ㄹ","ㅎ","ㅗ","ㅓ","ㅏ","ㅋ","ㅌ","ㅊ","ㅍ","ㅠ","ㅜ","ㅡ","ㅃ","ㅉ","ㄸ","ㄲ","ㅆ","ㅒ","ㅖ") ;
 
 //Kurdish
 $allletters['Kurdish']= array("١","وو","ي","ڕ","ط","ێ","ء","ح","ٶ","ث","|","آ","ش","ذ","إ","غ","أ","ك","ڵ","ض","ص","چ","ظ","ى","ة","ـ");
 
 //Lao
 $allletters['Lao']= array( "ຢ" , "ຟ" , "ໂ" , "ຖ" , "ຸ" , "ູ" , "ຄ" , "ຕ" , "ຈ" , "ຂ" , "ຊ" , "ໍ" , "ົ" , "ໄ" , "ຳ" , "ພ" , "ະ" , "ິ" , "ີ" , "ຮ" , "ນ" , "ຍ" , "ບ" , "ລ" , "“" , "ັ" , "ຫ" , "ກ" , "ດ" , "ເ" , "້" , "່" , "າ" , "ສ" , "ວ" , "ງ" , "ຜ" , "ປ" , "ແ" , "ອ" , "ຶ" , " ື" , "ທ" , "ມ" , "ໃ" , "ຝ" , "/" , "໑" , "໒" , "໓" , "໔" , "໌" , "ຼ" , "໕" , "໖" , "໗" , "໘" , "໙" , "ໍ່" , "ົ້" , "໐" , "ຳ້"  , "ິ້" , "ີ້" , "ຣ" , "ໜ" , "ຽ" , "ຫຼ" , "ັ້" , "໊" , "໋", "₭" , "(" , "ຯ"  , "ຶ້" , "ື້" , "ໆ" , "ໝ" ) ;
 
 
 //Latvian
 $allletters['Latvian']= array( "f" , "ū" , "g" , "j" , "r" , "m" , "v" , "n" , "z" , "ē" , "č" , "ž" , "h" , "ķ" , "š" , "u" , "s" , "i" , "l" , "d" , "a" , "t" , "e" , "c" , "ģ" , "ņ" , "b" , "ī" , "k" , "p" , "o" , "ā" , "ļ" ) ;
 
 //Lithuanian
 $allletters['Lithuanian']= array( "ą" , "č" , "ę" , "ė" , "į" , "š" , "ų" , "ū"   , "ž" , "q" , "w" , "e" , "r" , "t" , "y" , "u" , "i" , "o" , "p" ,  "a" , "s" , "d" , "f" , "g" , "h" , "j" , "k" , "l"  , "z" , "x" , "c" , "v" , "b" , "n" , "m" );
 
 
 $allletters['Malayalam']= array("ൊ"  , "ൃ" , "ൌ" , "ൈ" , "ാ" , "ീ" , "ൂ" , "ബ" , "ഹ" , "ഗ" , "ദ" , "ജ" , "ഡ" , "c"  , "ോ" , "േ" , "്" , "ി" , "ു" , "പ" , "ര" , "ക" , "ത" , "ച" , "ട" , "െ" , "ം" , "മ" , "ന" , "വ" , "ല" , "സ" , "," , "." , "യ" , "ഒ"  , "ഃ" , "ഋ" , "ഔ" , "ഐ" , "ആ" , "ഈ" , "ഊ" , "ഭ" , "ങ" , "ഘ" , "ധ" , "ഝ" , "ഢ" , "ഞ" , "ഓ" , "ഏ" , "അ" , "ഇ" , "ഉ" , "ഫ" , "റ" , "ഖ" , "ഥ" , "ഛ" , "ഠ" , "എ" , "ണ" , "ഴ" , "ള" , "ശ" , "ഷ");
 
 $allletters['Marathi']= array( "१" , "२" , "३" , "४" , "५" , "६" , "७" , "८" , "९" , "०"  , "ृ" , "ौ" , "ै" , "ा" , "ी" , "ू" , "ब" , "ह" , "ग" , "द" , "ज" , "ड" , "़" , "ॉ" , "ो" , "े" , "्" , "ि" , "ु" , "प" , "र" , "क" , "त" , "च" , "ट" , "ं" , "म" , "न" , "व" , "ल" , "स"   , "य" , "ऍ" , "ॅ" , "ः" , "ऋ" , "औ" , "ऐ" , "आ" , "ई" , "ऊ" , "भ" , "ङ" , "घ" , "ध" , "झ" , "ढ" , "ञ" , "ऑ" , "ओ" , "ए" , "अ" , "इ" , "उ" , "फ" , "ऱ" , "ख" , "थ" , "छ" , "ठ" , "ँ" , "ण" , "ळ" , "श" , "ष"   , "य़") ;
 
 $allletters['Nepali']= array("ञ" , "घ" , "ङ" , "झ" , "छ" , "ट" , "ठ" , "ड" , "ढ" , "ण" , "ध" , "भ" , "च" , "त" , "थ" , "ग" , "ष" , "य" , "उ" , "ृ" , "े" , "ब" , "क" , "म" , "ा" , "न" , "ज" , "व" , "प" , "ि" , "स" , "ु" , "श" , "ह" , "अ" , "ख" , "द" , "ल" , "फ" , "र" , "१" , "२" , "३" , "४" , "५" , "६" , "७" , "८" , "९" , "०" , "ं" , "ो" , "इ" , "ए" , "ै" , "्" , "ँ" , "ी" , "ू" , "ऋ");
 
 $allletters['Norwegian']= array("q" , "w" , "e" , "r" , "t" , "y" , "u" , "i" , "o" , "p" , "å" , "a" , "s" , "d" , "f" , "g" , "h" , "j" , "k" , "l" , "ø" , "æ" , "z" , "x" , "c" , "v" , "b" , "n" , "m" , "§");
 
 $allletters['Oriya']= array("ୃ" , "ୌ" , "ୈ" , "ା" , "ୀ" , "ୂ" , "ବ" , "ହ" , "ଗ" , "ଦ" , "ଜ" , "ଡ" , "଼" , "ୋ" , "େ" , "୍" , "ି" , "ୁ" , "ପ" , "ର" , "କ" , "ତ" , "ଚ" , "ଟ" , "ୟ" , "ଂ" , "ମ" , "ନ" , "ଲ" , "ସ" , "ଯ" , "@" , "୍ର" , "ର୍" , "ଜ୍ଞ" , "ତ୍ର" , "କ୍ଷ" , "ଶ୍ର" , "(" , ")" , "ଃ" , "ଋ" , "ଔ" , "ଐ" , "ଆ" , "ଈ" , "ଊ" , "ଭ" , "ଙ" , "ଘ" , "ଧ" , "ଝ" , "ଢ" , "ଞ" , "|" , "ଓ" , "ଏ" , "ଅ" , "ଇ" , "ଉ" , "ଫ" , "j" , "ଖ" , "ଥ" , "ଛ" , "ଠ" , "ୱ" , "ଁ" , "ଣ" , "v" , "b" , "ଳ" , "ଶ" , "ଷ" , "ଯ଼") ;
 
 $allletters['Polish']= array("q" , "w" , "e" , "r" , "t" , "z" , "u" , "i" , "o" , "p" , "ż" , "ś" , "ó" , "a" , "s" , "d" , "f" , "g" , "h" , "j" , "k" , "l" , "ł" , "ą" , "y" , "x" , "c" , "v" , "b" , "n" , "m" , "ń" , "ć" , "ź" , "ę");
 
 $allletters['Punjabi']= array(  "ੌ", "ੈ", "ਾ", "ੀ", "ੂ", "ਬ", "ਹ", "ਗ", "ਦ", "ਜ", "ਡ", "਼" , "ੋ", "ੇ", "੍", "ਿ", "ੁ", "ਪ", "ਰ", "ਕ", "ਤ", "ਚ", "ਟ" , "ੰ", "ਮ", "ਨ", "ਵ", "ਲ", "ਸ" , "ਯ" , "ੱ" ,   "ਔ", "ਐ", "ਆ", "ਈ", "ਊ", "ਭ", "ਙ", "ਘ", "ਧ", "ਝ", "ਢ", "ਞ" , "ਓ", "ਏ", "ਅ", "ਇ", "ਉ", "ਫ" , "ਖ", "ਥ", "ਛ", "ਠ"  , "ਂ", "ਣ" , "ੲ", "ਲ਼", "ਸ਼"     ) ;
 
 $allletters['Romanian']= array("q" , "w" , "e" , "r" , "t" , "y" , "u" , "i" , "o" , "p" , "ă" , "î" , "â" , "a" , "s" , "d" , "f" , "g" , "h" , "j" , "k" , "l" , "ș" , "ț" , "z" , "x" , "c" , "v" , "b" , "n" , "m");
 
 $allletters['Sinhala']= array("්‍ර" , "ු" , "අ" , "ැ" , "ර" , "ඒ" , "හ" , "ම" , "ස" , "ද" , "ච" , "ඤ" , "්" , "ි" , "ා" , "ෙ" , "ට" , "ය" , "ව" , "න" , "ක" , "ත" , "ං" , "ජ" , "ඩ" , "ඉ" , "බ" , "ප" , "ල" , "ග" , "/" , "ර්‍" , "ූ" , "උ" , "ෑ" , "ඍ" , "ඔ" , "ශ" , "ඹ" , "ෂ" , "ධ" , "ඡ" , "ඥ" , "ෟ" , "ී" , "ෘ" , "ෆ" , "ඨ" , "්‍ය" , "ළු" , "ණ" , "ඛ" , "ථ" , "ඃ" , "ඣ" , "ඪ" , "ඊ" , "භ" , "ඵ" , "ළ" , "ඝ")  ;
 
 $allletters['Slovak']= array("ľ" , "š" , "č" , "ť" , "ž" , "ý" , "á" , "í" , "é" , "q" , "w" , "e" , "r" , "t" , "z" , "u" , "i" , "o" , "p" , "ú" , "ä" , "ň" , "a" , "s" , "d" , "f" , "g" , "h" , "j" , "k" , "l" , "ô" , "§" , "y" , "x" , "c" , "v" , "b" , "n" , "m") ;
 
 $allletters['Slovenian']= array("q" , "w" , "e" , "r" , "t" , "z" , "u" , "i" , "o" , "p" , "š" , "đ" , "ž" , "a" , "s" , "d" , "f" , "g" , "h" , "j" , "k" , "l" , "č" , "ć" , "y" , "x" , "c" , "v" , "b" , "n" , "m");
 

 $allletters['Tamil']= array( "ஆ", "ஈ", "ஊ", "ஐ", "ஏ", "ள", "ற", "ன", "ட", "ண", "ச", "ஞ" , "அ", "இ", "உ", "்", "எ", "க", "ப", "ம", "த", "ந", "ய" , "ஔ", "ஓ", "ஒ", "வ", "ங", "ல", "ர" , "ஸ", "ஷ", "ஜ", "ஹ", "க்ஷ", "ஸ்ரீ", "ஶ", "i" , "௹", "௺", "௸", "ஃ", "g", "h", "j" , "௳", "௴", "௵", "௶", "௷", "n") ;
 
 $allletters['Telugu']= array(  "ృ", "ౌ", "ై", "ా", "ీ", "ూ", "బ", "హ", "గ", "ద", "జ", "డ"  , "ో", "ే", "్", "ి", "ు", "ప", "ర", "క", "త", "చ", "ట" , "ె", "ం", "మ", "న", "వ", "ల", "స" , "య", "ఒ" , "ఋ", "ఔ", "ఐ", "ఆ", "ఈ", "ఊ", "భ", "ఙ", "ఘ", "ధ", "ఝ", "ఢ", "ఞ", "ఓ", "ఏ", "అ", "ఇ", "ఉ", "ఫ", "ఱ", "ఖ", "థ", "ఛ", "ఠ", "ఎ", "ఁ", "ణ", "న" ,"ళ", "శ", "ష");
 
 $allletters['Tibetan']=array("ཨ" , "༡" , "༢" , "༣" , "༤" , "༥" , "༦" , "༧" , "༨" , "༩" , "༠" , "ཧ" , "ཝ" , "ཅ" , "ཆ" , "ེ" , "ར" , "ཏ" , "ཡ" , "ུ" , "ི" , "ོ" , "ཕ" , "ཙ" , "ཚ" , "ཛ" , "འ" , "ས" , "ད" , "བ" , "ང" , "མ" , "་" , "ག" , "ལ" , "ཞ" , "།" , "ཟ" , "ཤ" , "ཀ" , "ཁ" , "པ" , "ན" , "྅" , "ཐ" , "ཇ" , "ཉ" , "༁" , "༪" , "༫" , "༬" , "༭" , "༮" , "༯" , "༰" , "༱" , "༲" , "༳" , "༼" , "༽" , "༕" , "༖" , "༗" , "ྼ" , "ཊ" , "ྻ" , "༘" , "༙" , "ཌ" , "༾" , "༿" , "࿏" , "༂" , "༃" , "༆" , "༇" , "༸" , "༞" , "༴" , "ཥ" , "ཀྵ" , "ཎ" , "༹" , "ཋ" , "༺" , "༻") ;
 
 $allletters['Thai']= array(  "ภ", "ถ", "ุ", "ึ", "ค", "ต", "จ", "ข", "ช", "ๆ", "ไ", "ำ", "พ", "ะ", "ั", "ี", "ร", "น", "ย", "บ", "ล", "ฃ", "ฟ", "ห", "ก", "ด", "เ", "้", "่", "า", "ส", "ว", "ง", "ฃ", "ผ", "ป", "แ", "อ", "ิ", "ื", "ท", "ม", "ใ", "ฝ" , "๑", "๒", "๓", "๔", "ู", "฿", "๕", "๖", "๗", "๘", "๙", "๐" , "ฎ", "ฑ", "ธ", "ํ", "๊", "ณ", "ฯ", "ญ", "ฐ" , "ฅ", "ฤ", "ฆ", "ฏ", "โ", "ฌ", "็", "๋", "ษ", "ศ", "ซ" , "ฅ" , "ฉ", "ฮ", "ฺ", "์" , "ฒ", "ฬ", "ฦ");
 
 $allletters['Turkish']= array(  "q", "w", "e", "r", "t", "y", "u", "ı", "o", "p", "ğ", "ü",  "a", "s", "d", "f", "g", "h", "j", "k", "l", "ş", "i" , "z", "x", "c", "v", "b", "n", "m", "ö", "ç" , "é"  , "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "ğ", "ü" , "a", "s", "d", "f", "g", "h", "j", "k", "l", "ş", "i",  "z", "x", "c", "v", "b", "n", "m", "ö", "ç" );
 
 $allletters['Urdu']= array("ط" , "ص" , "ھ" , "د" , "ٹ" , "پ" , "ت" , "ب" , "ج" , "ح" , "م" , "و" , "ر" , "ن" , "ل" , "ا" , "ک" , "ی" , "ق" , "ف" , "س" , "ش" , "غ" , "ع" , "ظ" , "ض" , "ذ" , "ڈ" , "ث" , "چ" , "خ" , "ژ" , "ز" , "ڑ" , "ں" , "ء" , "آ" , "گ" , "ي" , "ۓ" , "‎" , "ؤ" , "ئ"  );
 
 $allletters['Ukrainian']=array("й" , "ц" , "у" , "к" , "е" , "н" , "г" , "ш" , "щ" , "з" , "х" , "ї" , "ф" , "і" , "в" , "а" , "п" , "р" , "о" , "л" , "д" , "ж" , "є" , "ґ" , "я" , "ч" , "с" , "м" , "и" , "т" , "ь" , "б" , "ю" , "₴" , "№");
 $allletters['Uzbek']=array("ё" , "ғ", "ҳ", "й", "ц", "у", "к", "е", "н", "г", "ш", "ў", "з", "х", "ъ", "ф", "қ", "в", "а", "п", "р", "о", "л", "д", "ж", "э" , "я", "ч", "с", "м", "и", "т", "ь", "б", "ю" , "ё" , "№"  , "ғ", "ҳ", "й", "ц", "у", "к", "е", "н", "г", "ш", "ў", "з", "х",    "ф", "қ", "в", "а", "п", "р", "о", "л", "д", "ж", "э" , "я", "ч", "с", "м", "и", "т", "ь", "б", "ю" );
 
 $allletters['Vietnamese'] = array("ă" , "â" , "ê" , "ô" , "̀" , "̉" , "̃" , "́" , "̣" , "đ" , "₫" , "q" , "w" , "e" , "r" , "t" , "y" , "u" , "i" , "o" , "p" , "ư" , "ơ" , "a" , "s" , "d" , "f" , "g" , "h" , "j" , "k" , "l" , "z" , "x" , "c" , "v" , "b" , "n" , "m");
 

 $wp_keyword_tool_google = get_option('wp_keyword_tool_google','google.com'); 
$wp_keyword_tool_alphabets=get_option('wp_keyword_tool_alphabets','a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z');
?>

<div class="wrap">
    <div style="margin-left:8px" class="icon32" id="icon-options-general">
        <br>
    </div>
    <h2><?php _e('Keyword tool for wordpress settings','wp_keyword_tool') ?></h2>
    <!--before  container-->
    <div class="metabox-holder" id="dashboard-widgets">
        <div style="width:49%;" class="postbox-container">
            <div style="min-height:1px;" class="meta-box-sortables ui-sortable" id="normal-sortables">
                <div class="postbox" id="dashboard_right_now">
                    <h3 class="hndle">
                        <span><?php _e('General settings','wp_keyword_tool') ?></span>
                    </h3>
                    <div class="inside main" style="padding-bottom:20px">
                        <!--/ before container-->
                        
                        	<div class="TTWForm-container-funny-fb ">
                        	      <form novalidate="" method="POST" class="TTWForm-funny-fb">
                        	      	
                        	      	
                        	      	<div class="TTWForm">                     
										
										<div class="field f_100" >
											<label>
												<?php _e('Google Site','wp_keyword_tool') ?> :
											</label>
											<select name="wp_keyword_tool_google" >
												
												<?php

												$googles="google.com google.ad google.ae google.com.af google.com.ag google.com.ai google.al google.am google.co.ao google.com.ar google.as google.at google.com.au google.az google.ba google.com.bd google.be google.bf google.bg google.com.bh google.bi google.bj google.com.bn google.com.bo google.com.br google.bs google.bt google.co.bw google.by google.com.bz google.ca google.cd google.cf google.cg google.ch google.ci google.co.ck google.cl google.cm google.cn google.com.co google.co.cr google.com.cu google.cv google.com.cy google.cz google.de google.dj google.dk google.dm google.com.do google.dz google.com.ec google.ee google.com.eg google.es google.com.et google.fi google.com.fj google.fm google.fr google.ga google.ge google.gg google.com.gh google.com.gi google.gl google.gm google.gp google.gr google.com.gt google.gy google.com.hk google.hn google.hr google.ht google.hu google.co.id google.ie google.co.il google.im google.co.in google.iq google.is google.it google.je google.com.jm google.jo google.co.jp google.co.ke google.com.kh google.ki google.kg google.co.kr google.com.kw google.kz google.la google.com.lb google.li google.lk google.co.ls google.lt google.lu google.lv google.com.ly google.co.ma google.md google.me google.mg google.mk google.ml google.com.mm google.mn google.ms google.com.mt google.mu google.mv google.mw google.com.mx google.com.my google.co.mz google.com.na google.com.nf google.com.ng google.com.ni google.ne google.nl google.no google.com.np google.nr google.nu google.co.nz google.com.om google.com.pa google.com.pe google.com.pg google.com.ph google.com.pk google.pl google.pn google.com.pr google.ps google.pt google.com.py google.com.qa google.ro google.ru google.rw google.com.sa google.com.sb google.sc google.se google.com.sg google.sh google.si google.sk google.com.sl google.sn google.so google.sm google.st google.com.sv google.td google.tg google.co.th google.com.tj google.tk google.tl google.tm google.tn google.to google.com.tr google.tt google.com.tw google.co.tz google.com.ua google.co.ug google.co.uk google.com.uy google.co.uz google.com.vc google.co.ve google.vg google.co.vi google.com.vn google.vu google.ws google.rs google.co.za google.co.zm google.co.zw google.cat ";
												$arr=explode(' ', $googles);
												$arr=array_filter($arr);			
													foreach($arr as $google){

														?>
														<option  value="<?php echo $google ?>"  <?php opt_selected($google,$wp_keyword_tool_google) ?> ><?php echo $google ?></option>
														<?php 
														

													}
												?>
												
												
												
											</select>

										</div>
										
										<div style="margin-top:10px;position:relative;">
										
										<div style="float:left;width:33%" id="field-wp_keyword_tool_alphabets-container" class="field f_100" >
											<label for="field-wp_keyword_tool_alphabets">
												Language letters
											</label>
											<br><textarea style="width:100%; height: 125px;" required="required" rows="5" cols="20" name="wp_keyword_tool_alphabets" id="field-wp_keyword_tool_alphabets"><?php echo $wp_keyword_tool_alphabets ?></textarea>
										</div> 
										
										
										<div style="width:30%;margin-top:20px;margin-left:10px;float:left"  id="field-language-container" class="field f_100" >
											
											<select style="width:100%;height:125px" name="language" size="6" id="field1zz">
												 
											</select>
										</div>
										
										<div style="float: left; display: inline; width: 30%; margin-left: 10px;margin-top:20px">
											<p><small style="width:100%"><i style="width:100%"><?php _e('Select your language from the list to get the letters if your language is not in the list add your language letters manually comma separated like a,b,c,... etc','wp_keyword_tool') ?></i></small></p>
										</div>
                        	      		
                        	      		<div class="clear"></div>
                        	      		</div>
                        	      		
                        	      		
                        	      	
		                        	      	<div id="form-submit" class="field f_100   submit">
		                        	      	    <input name="submit" value="<?php _e('Save options','wp_keyword_tool') ?>" type="submit">
		                        	      	</div>
                        	      	</div>
                        	      	
                        	      	 
                        	      </div><!--/TTWForm-->
                        	</div><!--/TTWForm-contain-->
                        
                        <!--after container-->
                        <div style="clear:both"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / start container-->
 

<div class="clear"></div>

<script type="text/javascript">
												
var alllangs= <?php echo json_encode($allletters) ?>;
jQuery.each(alllangs,function(k,v){
    
    jQuery('#field1zz').append('<option  value="'+ k +'" >'+k+'</option>')  ;

});
    
</script> 

<?php } ?>