using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VControlFlexTime : BDconexion
    {
        public List<EControlFlexTime> ControlFlexTime(String dnijefe, Int32 anhio, Int32 mes)
        {
            List<EControlFlexTime> lCControlFlexTime = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CControlFlexTime oVControlFlexTime = new CControlFlexTime();
                    lCControlFlexTime = oVControlFlexTime.ControlFlexTime(con, dnijefe, anhio, mes);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCControlFlexTime);
        }
    }
}