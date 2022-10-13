using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VConsultaVacacionedni : BDconexion
    {
        public List<EConsultaVacacionedni> Listar_ConsultaVacacionedni(Int32 post, Int32 id)
        {
            List<EConsultaVacacionedni> lCConsultaVacacionedni = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CConsultaVacacionedni oVConsultaVacacionedni = new CConsultaVacacionedni();
                    lCConsultaVacacionedni = oVConsultaVacacionedni.Listar_ConsultaVacacionedni(con, post, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCConsultaVacacionedni);
        }
    }
}