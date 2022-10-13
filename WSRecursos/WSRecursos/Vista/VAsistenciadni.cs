using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VAsistenciadni : BDconexion
    {
        public List<EAsistenciadni> Listar_Asistenciadni(String dni, String ffinicio, String ffin)
        {
            List<EAsistenciadni> lCAsistenciadni = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CAsistenciadni oVAsistenciadni = new CAsistenciadni();
                    lCAsistenciadni = oVAsistenciadni.Listar_Asistenciadni(con, dni, ffinicio, ffin);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCAsistenciadni);
        }
    }
}