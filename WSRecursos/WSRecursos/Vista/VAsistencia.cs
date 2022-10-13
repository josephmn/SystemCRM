using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VAsistencia : BDconexion
    {
        public List<EAsistencia> Listar_Asistencia(String ffinicio, String ffin)
        {
            List<EAsistencia> lCAsistencia = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CAsistencia oVAsistencia = new CAsistencia();
                    lCAsistencia = oVAsistencia.Listar_Asistencia(con, ffinicio, ffin);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCAsistencia);
        }
    }
}