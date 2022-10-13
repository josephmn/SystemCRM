using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VControlRemoto : BDconexion
    {
        public List<EControlRemoto> ControlRemoto(String dnijefe, Int32 anhio, Int32 mes)
        {
            List<EControlRemoto> lCControlRemoto = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CControlRemoto oVControlRemoto = new CControlRemoto();
                    lCControlRemoto = oVControlRemoto.ControlRemoto(con, dnijefe, anhio, mes);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCControlRemoto);
        }
    }
}