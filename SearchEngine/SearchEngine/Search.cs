using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SearchEngine
{
    class Search
    {

        public Search()
        {
            
        }

        public static bool isFound(int idx, string text, string keyword)
        {//mengecek apakah suatu bagian dari text yang dimulai dari indeks ke-idx mengandung keyword
            int textlength = text.Length;
            int keywordlength = keyword.Length;
            if (idx + keywordlength <= textlength)
            {
                int i = 0;
                int j = keywordlength - 1;
                bool found = true;
                while ((found) && (i <= j))
                {
                if (char.ToUpperInvariant(text.ElementAt(idx + i)) == char.ToUpperInvariant(keyword.ElementAt(i)))
                {
                        i++;

                    }
                    else
                    {
                        found = false;
                        break;
                        
                    }
                }
                return found;
            }
            else
            {
                return false;
            }

        }

        public static void searchString(string keyword, string text, ref bool found, ref string excerpt)
        {//mengecek apakah keyword terdapat pada suatu string
            excerpt = null;
            found = false;
            int length = text.Length;
            int i = 0;
            while ((!found) && (i < length))
            {
                if (isFound(i, text, keyword))
                {
                    found = true;
                    break;
                }
                i++;
            }

            if (found)
            {
                excerpt = getExcerpt(i, text,keyword.Length);
            }

        }

        private static string getExcerpt(int idx, string text, int lgt)
        {//mendapatkan sebagian string di sekitar indeks ditemukannya keyword.
          //Pre-kondisi string mengandung keyword
            int excerptLength = 0;
            string excerpt="";
            if (text.Length < 100)
            {
                excerptLength = text.Length;
                excerpt = text;
            }
            else
            {
                excerptLength = 100;
                excerpt += "..";
                int idxawal;
                if ((idx - excerptLength/2) > 0)
                {
                    idxawal = idx - excerptLength / 2;
                }
                else
                {
                    idxawal = 0;
                }
                int idxakhir=0;
                if(idxawal + excerptLength < text.Length){
                    
                } else {
                    idxakhir = text.Length - 1;
                    idxawal = idxakhir - 99;

                }
                excerpt = text.Substring(idxawal, excerptLength);
                //excerpt = text.Substring(idxawal, idx - idxawal) + "<strong>" + text.Substring(idx,lgt) + "</strong>" + text.Substring(idx + lgt, excerptLength - lgt - (idx - idxawal));

            }
            return excerpt;
        }
    }
}
