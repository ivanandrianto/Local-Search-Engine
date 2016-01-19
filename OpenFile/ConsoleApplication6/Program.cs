using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ConsoleApplication6
{
    class Program
    {
        static void Main(string[] args)
        {
            string a = args[0].Replace("%20", " ");
            System.Diagnostics.Process.Start(a);
        }
    }
}
