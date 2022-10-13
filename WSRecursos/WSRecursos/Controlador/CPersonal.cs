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
    public class CPersonal
    {
        public List<EPersonal> Listar_Personal(SqlConnection con, Int32 post, string dni, Int32 local)
        {
            List<EPersonal> lEPersonal = null;
            SqlCommand cmd = new SqlCommand("ASP_PERSONAL", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@local", SqlDbType.Int).Value = local;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEPersonal = new List<EPersonal>();

                EPersonal obEPersonal = null;
                while (drd.Read())
                {
                    obEPersonal = new EPersonal();
                    obEPersonal.i_id = drd["i_id"].ToString();
                    obEPersonal.v_dni = drd["v_dni"].ToString();
                    obEPersonal.v_nombres = drd["v_nombres"].ToString();
                    obEPersonal.v_paterno = drd["v_paterno"].ToString();
                    obEPersonal.v_materno = drd["v_materno"].ToString();
                    obEPersonal.v_correo = drd["v_correo"].ToString();
                    obEPersonal.v_area = drd["v_area"].ToString();
                    obEPersonal.v_cargo = drd["v_cargo"].ToString();
                    obEPersonal.d_fingreso = drd["d_fingreso"].ToString();
                    obEPersonal.i_estado = drd["i_estado"].ToString();
                    obEPersonal.id_zona = drd["id_zona"].ToString();
                    obEPersonal.v_zona = drd["v_zona"].ToString();
                    obEPersonal.id_local = drd["id_local"].ToString();
                    obEPersonal.v_local = drd["v_local"].ToString();
                    obEPersonal.id_area = drd["id_area"].ToString();
                    obEPersonal.v_area_indicador = drd["v_area_indicador"].ToString();
                    obEPersonal.id_cargo = drd["id_cargo"].ToString();
                    obEPersonal.v_cargo_indicador = drd["v_cargo_indicador"].ToString();
                    obEPersonal.i_turno = drd["i_turno"].ToString();
                    obEPersonal.v_turno = drd["v_turno"].ToString();
                    obEPersonal.i_flex = drd["i_flex"].ToString();
                    obEPersonal.v_flex = drd["v_flex"].ToString();
                    obEPersonal.i_remoto = drd["i_remoto"].ToString();
                    obEPersonal.v_remoto = drd["v_remoto"].ToString();
                    obEPersonal.i_marcacion = drd["i_marcacion"].ToString();
                    obEPersonal.v_marcacion = drd["v_marcacion"].ToString();
                    obEPersonal.i_venta = drd["i_venta"].ToString();
                    obEPersonal.v_venta = drd["v_venta"].ToString();
                    lEPersonal.Add(obEPersonal);
                }
                drd.Close();
            }

            return (lEPersonal);
        }
    }
}