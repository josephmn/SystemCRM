using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CGrupoArea
    {
        public List<EGrupoArea> Listar_GrupoArea(SqlConnection con)
        {
            List<EGrupoArea> lEGrupoArea = null;
            SqlCommand cmd = new SqlCommand("ASP_GRUPO_AREA", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEGrupoArea = new List<EGrupoArea>();

                EGrupoArea obEGrupoArea = null;
                while (drd.Read())
                {
                    obEGrupoArea = new EGrupoArea();
                    obEGrupoArea.i_codigo = drd["i_codigo"].ToString();
                    obEGrupoArea.v_descripcion = drd["v_descripcion"].ToString();
                    lEGrupoArea.Add(obEGrupoArea);
                }
                drd.Close();
            }

            return (lEGrupoArea);
        }
    }
}